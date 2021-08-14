<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Exercises;
use App\Models\Lesson;
use App\Models\LessonTraining;
use App\Models\Video;
use App\Repositories\LessonRepository;
use App\Repositories\LevelRepository;
use App\Repositories\VideoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $lessons = Lesson::with('hasLevel')->orderBy('id', 'DESC')->paginate(PAGE_SIZE);

        return view('admin.lessons.index', [
            'lessons' => $lessons,
        ]);
    }

    public function create()
    {
        $levels = $this->levelRepository->fetchAll([], ['id', 'name']);
        $videos = $this->videoRepository->fetchAll([], ['id', 'title']);
        $course = Course::where('status', 1)->get();

        return view('admin.lessons.create', [
            'levels' => $levels,
            'videos' => $videos,
            'course' => $course,
        ]);
    }

    public function store(Request $request)
    {
        //dd($request);

        $name = $request->name;
        $description = $request->description;
        $level_id = $request->level_id;
        $course_id = $request->course_id;
        $status = $request->status;

        $videoGrammarIds = $request->videoGrammarIds;
        $videoLessonIds = $request->videoLessonIds;

        $speak_name_en = $request->input('speak_name_en', []);
        $speak_name_vi = $request->input('speak_name_vi', []);

        $write_name_en = $request->input('write_name_en', []);
        $write_name_vi = $request->input('write_name_vi', []);

        $exercises_name = $request->input('exercises_name', []);
        $answer_1 = $request->input('answer_1', []);
        $answer_2 = $request->input('answer_2', []);
        $answer_3 = $request->input('answer_3', []);
        $answer_4 = $request->input('answer_4', []);
        $answer_correct = $request->input('answer_correct', []);

        $thumbVal = $request->thumb;
        if ($request->hasFile('thumb')) {
            if (!isUrl($request->thumb)) {
                $path = $request->file('thumb')->store('thumbnails', 'public');
                $thumbVal = $path;
            }
        }

        $arrGrammarIds = explode(',', $videoGrammarIds);
        $arrLessonIds = explode(',', $videoLessonIds);

        $videoIds = array(
            'grammar' => $arrGrammarIds,
            'lesson' => $arrLessonIds,
        );

        $dataLesson = [
            'name' => $name,
            'description' => $description,
            'thumb_img' => $thumbVal,
            'video_ids' => json_encode($videoIds),
            'level_id' => $level_id,
            'course_id' => $course_id,
            'status' => $status,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => \Carbon\Carbon::now(),
        ];

        // insert Lesson
        //$lesson = $this->levelRepository->storeNew($dataLesson);
        /*$lesson = Lesson::create($dataLesson);
        $lessonId = $lesson->id();*/
        $lessonId = DB::table('lessons')->insertGetId($dataLesson);

        if ($lessonId > 0) {

            $dataSpeak = [];
            foreach ($speak_name_en as $index => $value) {
                $dataSpeak[] = [
                    'en' => $speak_name_en[$index],
                    'vi' => $speak_name_vi[$index],
                    'type' => config('common.lesson_training_types.speaking'),
                    'lesson_id' => $lessonId,
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => \Carbon\Carbon::now(),
                ];
            }

            $dataWrite = [];
            foreach ($write_name_en as $index => $value) {
                $dataWrite[] = [
                    'en' => $write_name_en[$index],
                    'vi' => $write_name_vi[$index],
                    'type' => config('common.lesson_training_types.writing'),
                    'lesson_id' => $lessonId,
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => \Carbon\Carbon::now(),
                ];
            }

            $dataExercises = [];
            foreach ($exercises_name as $index => $value) {
                $dataExercises[] = [
                    'name' => $exercises_name[$index],
                    'answer_1' => $answer_1[$index],
                    'answer_2' => $answer_2[$index],
                    'answer_3' => $answer_3[$index],
                    'answer_4' => $answer_4[$index],
                    'level_id' => $level_id,
                    'lesson_id' => $lessonId,
                    'answer_correct' => $answer_correct[$index],
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => \Carbon\Carbon::now(),
                ];
            }

            $speakStore = LessonTraining::insert($dataSpeak);
            $writeStore = LessonTraining::insert($dataWrite);
            $exercisesStore = Exercises::insert($dataExercises);
        }

        /*$mData = [];
        $mData [] = [
            'data' => $dataLesson,
            'dataSpeak' => $dataSpeak,
            'dataWrite' => $dataWrite,
            'dataExercises' => $dataExercises,
        ];
        dd($mData);*/

        return redirect()->route('admin.lesson.index')->with($lessonId > 0 ? SUCCESS : ERROR, $lessonId > 0 ? CREATE_SUCCESS : CREATE_ERROR);
    }

    public function edit($id)
    {
        $lesson = $this->lessonRepository->findById($id, ['hasVideos']);
        $levels = $this->levelRepository->fetchAll([]);
        $videos = $this->videoRepository->fetchAll([], ['id', 'title']);
        $course = Course::where('status', 1)->get();
        $speakingData = LessonTraining::where('status', 1)->where('lesson_id', $lesson->id)->where('type', config('common.lesson_training_types.speaking'))->get();
        $writingData = LessonTraining::where('status', 1)->where('lesson_id', $lesson->id)->where('type', config('common.lesson_training_types.writing'))->get();
        $exercisesData = Exercises::where('status', 1)->where('lesson_id', $lesson->id)->get();

        $videosIds = json_decode($lesson->video_ids);
        $grammarIds = $videosIds->grammar;
        $lessonIds = $videosIds->lesson;

        $grammarVideoData = Video::where('status', 1)->whereIn('id', $grammarIds)->get();
        $lessonVideoData = Video::where('status', 1)->whereIn('id', $lessonIds)->get();

        return view('admin.lessons.update', [
            'lesson' => $lesson,
            'levels' => $levels,
            'videos' => $videos,
            'course' => $course,
            'grammarIds' => implode(',', $grammarIds),
            'lessonIds' => implode(',', $lessonIds),
            'grammarVideoData' => $grammarVideoData,
            'lessonVideoData' => $lessonVideoData,
            'speakingData' => $speakingData,
            'writingData' => $writingData,
            'exercisesData' => $exercisesData,
        ]);
    }

    public function getIdsLessonRemove($dataOrigin, $newIds)
    {
        $ids = [];
        if (!empty($dataOrigin) && !empty($newIds)) {
            foreach ($dataOrigin as $index => $itemOrigin) {
                if (in_array($itemOrigin->id, $newIds) == false) {
                    array_push($ids, $itemOrigin->id);
                }
            }
        }
        return $ids;
    }

    public function update(Request $request)
    {
        //dd($request);

        $lessonId = $request->id;
        $name = $request->name;
        $description = $request->description;
        $level_id = $request->level_id;
        $course_id = $request->course_id;
        $status = $request->status;

        $videoGrammarIds = $request->videoGrammarIds;
        $videoLessonIds = $request->videoLessonIds;

        $speak_name_en = $request->speak_name_en;
        $speak_name_vi = $request->speak_name_vi;

        $write_name_en = $request->write_name_en;
        $write_name_vi = $request->write_name_vi;

        $exercises_name = $request->exercises_name;
        $answer_1 = $request->answer_1;
        $answer_2 = $request->answer_2;
        $answer_3 = $request->answer_3;
        $answer_4 = $request->answer_4;
        $answer_correct = $request->answer_correct;

        $id_speak = $request->id_speak;
        $id_write = $request->id_write;
        $id_exercises = $request->id_exercises;

        $lessonDetail = $this->lessonRepository->findById($lessonId, []);

        /*$videosIds = json_decode($lessonDetail->video_ids);
        $grammarIdsOrigin = $videosIds->grammar;
        $lessonIdsOrigin = $videosIds->lesson;*/

        $thumbVal = $request->thumb;
        if ($request->hasFile('thumb')) {
            // remove old image
            if (!empty($lessonDetail->thumb) && !isUrl($request->thumb)) {
                if (file_exists('storage/' . $lessonDetail->thumb)) {
                    unlink('storage/' . $lessonDetail->thumb);
                };
            }
            if (!isUrl($request->thumb)) {
                $path = $request->file('thumb')->store('thumbnails', 'public');
                $thumbVal = $path;
            }
        }

        $videoIds = array(
            'grammar' => explode(',', $videoGrammarIds),
            'lesson' => explode(',', $videoLessonIds),
        );

        if (empty($thumbVal)) {
            $dataLesson = [
                'name' => $name,
                'description' => $description,
                'video_ids' => json_encode($videoIds),
                'level_id' => $level_id,
                'course_id' => $course_id,
                'status' => $status,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
            ];
        } else {
            $dataLesson = [
                'name' => $name,
                'description' => $description,
                'thumb_img' => $thumbVal,
                'video_ids' => json_encode($videoIds),
                'level_id' => $level_id,
                'course_id' => $course_id,
                'status' => $status,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => \Carbon\Carbon::now(),
            ];
        }

        // update lesson
        $update = Lesson::where('id', $lessonId)->update($dataLesson);

        if ($lessonId > 0) {
            // delete Speak, Write, Exercises is remove by ids
            $speakIdsOld = LessonTraining::select('id', 'en', 'vi')
                ->where('lesson_id', $lessonId)
                ->where('type', config('common.lesson_training_types.speaking'))
                ->get();
            $idsSpeakRemove = $this->getIdsLessonRemove($speakIdsOld, $id_speak);
            if (!empty($idsSpeakRemove)) {
                LessonTraining::whereIn('id', $idsSpeakRemove)->delete();
            }

            $writeIdsOld = LessonTraining::select('id', 'en', 'vi')
                ->where('lesson_id', $lessonId)
                ->where('type', config('common.lesson_training_types.writing'))
                ->get();
            $idsWriteRemove = $this->getIdsLessonRemove($writeIdsOld, $id_write);
            if (!empty($idsWriteRemove)) {
                LessonTraining::whereIn('id', $idsWriteRemove)->delete();
            }

            $exercisesIdsOld = Exercises::select('id', 'name')->where('lesson_id', $lessonId)->get();
            $idsExercisesRemove = $this->getIdsLessonRemove($exercisesIdsOld, $id_exercises);
            if (!empty($idsExercisesRemove)) {
                Exercises::whereIn('id', $idsExercisesRemove)->delete();
            }

            // insert or update  Speak, Write, Exercises
            foreach ($id_speak as $index => $id) {
                $dataSpeak = [
                    'en' => $speak_name_en[$index],
                    'vi' => $speak_name_vi[$index],
                    'type' => config('common.lesson_training_types.speaking'),
                    'lesson_id' => $lessonId,
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => \Carbon\Carbon::now(),
                ];

                if ($id > 0) {
                    LessonTraining::where('id', $id)->update($dataSpeak);
                } else {
                    LessonTraining::insert($dataSpeak);
                }
            }

            foreach ($id_write as $index => $id) {
                $dataWrite = [
                    'en' => $write_name_en[$index],
                    'vi' => $write_name_vi[$index],
                    'type' => config('common.lesson_training_types.writing'),
                    'lesson_id' => $lessonId,
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => \Carbon\Carbon::now(),
                ];

                if ($id > 0) {
                    LessonTraining::where('id', $id)->update($dataWrite);
                } else {
                    LessonTraining::insert($dataWrite);
                }
            }

            foreach ($id_exercises as $index => $id) {
                $dataExercises = [
                    'name' => $exercises_name[$index],
                    'answer_1' => $answer_1[$index],
                    'answer_2' => $answer_2[$index],
                    'answer_3' => $answer_3[$index],
                    'answer_4' => $answer_4[$index],
                    'level_id' => $level_id,
                    'lesson_id' => $lessonId,
                    'answer_correct' => $answer_correct[$index],
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => \Carbon\Carbon::now(),
                ];

                if ($id > 0) {
                    Exercises::where('id', $id)->update($dataExercises);
                } else {
                    Exercises::insert($dataExercises);
                }
            }
        }

        return redirect()->route('admin.lesson.index')->with($update > 0 ? SUCCESS : ERROR, $update > 0 ? UPDATE_SUCCESS : UPDATE_ERROR);
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

    public function getVideos(Request $request)
    {
        $type = $request->type;
        $keyName = $request->keyName;

        $query = Video::query();
        if (!empty($type)) {
            $query->where('type', $type);
        }
        if (!empty($keyName)) {
            $query->where('title', 'LIKE', '%' . request('keyName') . '%');
        }
        $videos = $query->orderBy('id', 'DESC')->select('*')->limit(100)->get();

        return response()->json([
            'videos' => $videos,
        ]);
    }

    public function refreshLessonTraining(Request $request)
    {
        dd($request->all());
    }

}
