<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\LessonRequest;
use App\Models\Lesson;
use App\Repositories\LessonRepository;
use App\Repositories\LevelRepository;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    protected $lessonRepository;
    protected $levelRepository;

    public function __construct(LessonRepository $lessonRepository, LevelRepository $levelRepository)
    {
        $this->lessonRepository = $lessonRepository;
        $this->levelRepository = $levelRepository;
    }

    /**
     * @return View
     */
    public function index()
    {
        $lessons = Lesson::with('hasLevel')->paginate(5);

        return view('admin.lessons.index', [
            'lessons' => $lessons,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $levels = $this->levelRepository->fetchAll([], ['id', 'name']);

        return view('admin.lessons.create', [
            'levels' => $levels,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(LessonRequest $request)
    {
        $data = $request->except('_token', 'files');

        if ($request->hasFile('thumb_img')) {
            $path = $request->file('thumb_img')->store('thumbnails', 'public');

            $data['thumb_img'] = $path;
        }

        $this->lessonRepository->storeNew($data);

        return redirect()->route('admin.lesson.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lesson = $this->lessonRepository->findById($id, []);
        $levels = $this->levelRepository->fetchAll([]);

        return view('admin.lessons.update', [
            'lesson' => $lesson,
            'levels' => $levels,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->except('_token', 'files');

        if ($request->hasFile('thumb_img')) {
            $path = $request->file('thumb_img')->store('thumbnails', 'public');

            $data['thumb_img'] = $path;
        }
        $this->lessonRepository->update($request->id, $data);

        return redirect()->route('admin.lesson.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
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
