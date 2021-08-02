<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\LessonRequest;
use App\Models\Lesson;
use App\Repositories\LessonRepository;
use App\Repositories\LevelRepository;
use App\Repositories\VideoRepository;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    protected $lessonRepository;
    protected $levelRepository;
    protected $videoRepository;

    public function __construct(LessonRepository $lessonRepository, LevelRepository $levelRepository, VideoRepository $videoRepository)
    {
        $this->lessonRepository = $lessonRepository;
        $this->levelRepository = $levelRepository;
        $this->videoRepository = $videoRepository;
    }

    public function index()
    {
        $lessons = Lesson::with('hasLevel', 'hasVideos')->paginate(5);

        return view('admin.lessons.index', [
            'lessons' => $lessons,
        ]);
    }

    public function create()
    {
        $levels = $this->levelRepository->fetchAll([], ['id', 'name']);
        $videos = $this->videoRepository->fetchAll([], ['id', 'title']);

        return view('admin.lessons.create', [
            'levels' => $levels,
            'videos' => $videos,
        ]);
    }

    public function store(LessonRequest $request)
    {
        $data = $request->except('_token', 'files', 'videos');
        $videos = $request->videos;

        if ($request->hasFile('thumb_img')) {
            $path = $request->file('thumb_img')->store('thumbnails', 'public');

            $data['thumb_img'] = $path;
        }

        $saveLesson = $this->lessonRepository->storeNew($data);
        $saveLesson->hasVideos()->sync($videos);

        return redirect()->route('admin.lesson.index');
    }

    public function edit($id)
    {
        $lesson = $this->lessonRepository->findById($id, ['hasVideos']);
        $levels = $this->levelRepository->fetchAll([]);
        $videos = $this->videoRepository->fetchAll([], ['id', 'title']);

        return view('admin.lessons.update', [
            'lesson' => $lesson,
            'levels' => $levels,
            'videos' => $videos,
        ]);
    }

    public function update(LessonRequest $request)
    {
        $currentLesson = $this->lessonRepository->findById($request->id, []);
        $videos = $request->videos;
        $currentLesson->hasVideos()->detach($videos);
        $currentLesson->hasVideos()->sync($videos);

        $data = $request->except('_token', 'files', 'videos');

        if ($request->hasFile('thumb_img')) {
            $path = $request->file('thumb_img')->store('thumbnails', 'public');

            $data['thumb_img'] = $path;
        }
        $this->lessonRepository->update($request->id, $data);

        return redirect()->route('admin.lesson.index');
    }

    public function destroy($id)
    {
        $lesson = $this->lessonRepository->findById($id, []);

        if ($lesson->exists()) {
            $this->lessonRepository->deleteById($id);

            return response()->json([
                'msg' => 'Xóa bài học thành công',
            ]);
        }

        return response()->json([
            'error' => 'Không tìm thấy bài học',
        ], 404);
    }
}
