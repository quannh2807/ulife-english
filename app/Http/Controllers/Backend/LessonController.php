<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ActOut;
use App\Models\ActOutCharacter;
use App\Models\Course;
use App\Models\Exercises;
use App\Models\Lesson;
use App\Models\LessonTraining;
use App\Models\Video;
use App\Repositories\LessonRepository;
use App\Repositories\LevelRepository;
use App\Repositories\VideoRepository;
use Benlipp\SrtParser\Parser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $courseData = DB::table('courses')->where('status', 1)->get();

        return view('admin.lessons.index', [
            'lessons' => $lessons,
            'courseData' => $courseData,
        ]);
    }

    public function search(Request $request)
    {
        $question = Lesson::query();
        if (!empty(request('keyword'))) {
            $question->where('name', 'LIKE', '%' . request('keyword') . '%');
            $question->orWhere('id', request('keyword'));
        }
        if (!empty(request('rangeDate'))) {
            $temp = explode('-', request('rangeDate'));
            $startDate = trim($temp[0]);
            $endDate = trim($temp[1]);
            $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', $startDate)
                ->format('Y-m-d 00:00:00');
            $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', $endDate)
                ->format('Y-m-d 23:59:59');

            $question->where('created_at', '>=', $startDate)
                ->where('created_at', '<=', $endDate);
        }
        if (!empty(request('courses'))) {
            $question->where('course_id', request('courses'));
        }
        if (request('status') >= 0) {
            $question->where('status', request('status'));
        }
        $data = $question->orderBy('id', 'DESC')->paginate(10);

        $courseData = DB::table('courses')->where('status', 1)->get();

        return view('admin.lessons.index', [
            'lessons' => $data,
            'courseData' => $courseData,
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
        $name = $request->name;
        $description = $request->description;
        $level_id = $request->level_id;
        $course_id = $request->course_id;
        $position = $request->position;
        $status = $request->status;

        $videoGrammarIds = $request->videoGrammarIds;
        $videoLessonIds = $request->videoLessonIds;
        // speak
        $speak_name_en = $request->input('speak_name_en', []);
        $speak_name_vi = $request->input('speak_name_vi', []);
        // upload file ghi am |storeAs($path, $name, $options = [])
        $speak_file_vi = [];
        if ($request->hasFile('speak_file_vi')) {
            $arr_speak_file_vi = $request->file('speak_file_vi');
            foreach ($arr_speak_file_vi as $key => $file) {
                $path = $file->storeAs('lesson-training/speak', 'speak_' . uniqid() . '_' . $file->getClientOriginalName(), 'public');
                $speak_file_vi[$key] = $path;
            }
        }
        $speak_file_en = [];
        if ($request->hasFile('speak_file_en')) {
            $arr_speak_file_en = $request->file('speak_file_en');
            foreach ($arr_speak_file_en as $key => $file) {
                $path = $file->storeAs('lesson-training/speak', 'speak_' . uniqid() . '_' . $file->getClientOriginalName(), 'public');
                $speak_file_en[$key] = $path;
            }
        }

        // write
        $write_name_en = $request->input('write_name_en', []);
        $write_name_vi = $request->input('write_name_vi', []);
        // upload file ghi am
        $write_file_vi = [];
        if ($request->hasFile('write_file_vi')) {
            $write_file_vi = $request->file('write_file_vi');
            foreach ($write_file_vi as $key => $file) {
                $path = $file->storeAs('lesson-training/write', 'write_' . uniqid() . '_' . $file->getClientOriginalName(), 'public');
                $write_file_vi[$key] = $path;
            }
        }
        $write_file_en = [];
        if ($request->hasFile('write_file_en')) {
            $write_file_en = $request->file('write_file_en');
            foreach ($write_file_en as $key => $file) {
                $path = $file->storeAs('lesson-training/write', 'write_' . uniqid() . '_' . $file->getClientOriginalName(), 'public');
                $write_file_en[$key] = $path;
            }
        }

        // do exercises
        $exercises_name = $request->input('exercises_name', []);
        $answer_1 = $request->input('answer_1', []);
        $answer_2 = $request->input('answer_2', []);
        $answer_3 = $request->input('answer_3', []);
        $answer_4 = $request->input('answer_4', []);
        $answer_correct = $request->input('answer_correct', []);
        $answer_description = $request->input('answer_description', []);

        // act out
        $actOutNameOne = $request->actOutNameOne;
        $actOutNameTwo = $request->actOutNameTwo;

        $actOutCharacterId = $request->input('actOutCharacterId', []);
        $actOutTimeStart = $request->input('actOutTimeStart', []);
        $actOutTimeEnd = $request->input('actOutTimeEnd', []);
        $actOutEn = $request->input('actOutEn', []);
        $actOutVi = $request->input('actOutVi', []);

        $thumbVal = $request->thumb;
        if ($request->hasFile('thumb')) {
            if (!isUrl($request->thumb)) {
                $path = $request->file('thumb')->store('thumbnails', 'public');
                $thumbVal = $path;
            }
        }

        $avatarOne = $request->characterOneUpload;
        if ($request->hasFile('characterOneUpload')) {
            if (!isUrl($request->characterOneUpload)) {
                $path = $request->file('characterOneUpload')->store('avatar', 'public');
                $avatarOne = $path;
            }
        }

        $avatarTwo = $request->characterTwoUpload;
        if ($request->hasFile('characterTwoUpload')) {
            if (!isUrl($request->characterTwoUpload)) {
                $path = $request->file('characterTwoUpload')->store('avatar', 'public');
                $avatarTwo = $path;
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
            'position' => $position,
            'video_ids' => json_encode($videoIds),
            'level_id' => $level_id,
            'course_id' => $course_id,
            'status' => $status,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
            'created_at' => \Carbon\Carbon::now(),
        ];

        // insert Lesson
        $lessonId = Lesson::insertGetId($dataLesson);

        if ($lessonId > 0) {

            $dataSpeak = [];
            foreach ($speak_name_en as $index => $value) {
                $dataSpeak[] = [
                    'en' => $speak_name_en[$index],
                    'vi' => $speak_name_vi[$index],
                    'type' => config('common.lesson_training_types.speaking'),
                    'lesson_id' => $lessonId,
                    'file_vi' => array_key_exists($index, $speak_file_vi) ? $speak_file_vi[$index] : null,
                    'file_en' => array_key_exists($index, $speak_file_en) ? $speak_file_en[$index] : null,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
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
                    'file_vi' => array_key_exists($index, $write_file_vi) ? $write_file_vi[$index] : null,
                    'file_en' => array_key_exists($index, $write_file_en) ? $write_file_en[$index] : null,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
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
                    'description' => $answer_description[$index],
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                    'created_at' => \Carbon\Carbon::now(),
                ];
            }

            if (!empty($actOutTimeStart)) {
                $dataActOut = [];
                foreach ($actOutTimeStart as $index => $value) {
                    $dataActOut[] = [
                        'lesson_id' => $lessonId,
                        'time_start' => $actOutTimeStart[$index],
                        'time_end' => $actOutTimeEnd[$index],
                        'en' => $actOutEn[$index],
                        'vi' => $actOutVi[$index],
                        'characterId' => $actOutCharacterId[$index],
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id,
                        'created_at' => \Carbon\Carbon::now(),
                    ];
                }

                ActOut::insert($dataActOut);

                $dataCharacter = array(
                    array(
                        'lesson_id' => $lessonId,
                        'characterId' => 1,
                        'characterName' => $actOutNameOne,
                        'image' => $avatarOne,
                        'created_at' => \Carbon\Carbon::now(),
                    ),
                    array(
                        'lesson_id' => $lessonId,
                        'characterId' => 2,
                        'characterName' => $actOutNameTwo,
                        'image' => $avatarTwo,
                        'created_at' => \Carbon\Carbon::now(),
                    )
                );

                ActOutCharacter::insert($dataCharacter);
            }

            LessonTraining::insert($dataSpeak);
            LessonTraining::insert($dataWrite);
            Exercises::insert($dataExercises);
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
        $lesson = $this->lessonRepository->findById($id, []);
        $levels = $this->levelRepository->fetchAll([]);
        $videos = $this->videoRepository->fetchAll([], ['id', 'title']);
        $course = Course::where('status', 1)->get();
        //$actOutCharacter = ActOutCharacter::where('lesson_id', $lesson->id)->get();
        $actOutCharacter = $lesson->hasCharacters;

        $speakingData = LessonTraining::where('status', 1)->where('lesson_id', $lesson->id)->where('type', config('common.lesson_training_types.speaking'))->get();
        $writingData = LessonTraining::where('status', 1)->where('lesson_id', $lesson->id)->where('type', config('common.lesson_training_types.writing'))->get();
        $exercisesData = Exercises::where('status', 1)->where('lesson_id', $lesson->id)->get();
        $actOutData = ActOut::where('status', 1)->where('lesson_id', $lesson->id)->get();

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
            'actOutData' => $actOutData,
            'actOutCharacter' => $actOutCharacter,
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
        $lessonId = $request->id;
        $name = $request->name;
        $description = $request->description;
        $level_id = $request->level_id;
        $course_id = $request->course_id;
        $position = $request->position;
        $status = $request->status;

        $videoGrammarIds = $request->videoGrammarIds;
        $videoLessonIds = $request->videoLessonIds;

        // speaking
        $speak_name_en = $request->speak_name_en;
        $speak_name_vi = $request->speak_name_vi;
        // upload file ghi am |storeAs($path, $name, $options = [])
        $speak_file_vi = [];
        if ($request->hasFile('speak_file_vi')) {
            $arr_speak_file_vi = $request->file('speak_file_vi');
            foreach ($arr_speak_file_vi as $key => $file) {
                $path = $file->storeAs('lesson-training/speak', 'speak_' . uniqid() . '_' . $file->getClientOriginalName(), 'public');
                $speak_file_vi[$key] = $path;
            }
        }
        $speak_file_en = [];
        if ($request->hasFile('speak_file_en')) {
            $arr_speak_file_en = $request->file('speak_file_en');
            foreach ($arr_speak_file_en as $key => $file) {
                $path = $file->storeAs('lesson-training/speak', 'speak_' . uniqid() . '_' . $file->getClientOriginalName(), 'public');
                $speak_file_en[$key] = $path;
            }
        }

        // writting
        $write_name_en = $request->write_name_en;
        $write_name_vi = $request->write_name_vi;
        // upload file ghi am
        $write_file_vi = [];
        if ($request->hasFile('write_file_vi')) {
            $write_file_vi = $request->file('write_file_vi');
            foreach ($write_file_vi as $key => $file) {
                $path = $file->storeAs('lesson-training/write', 'write_' . uniqid() . '_' . $file->getClientOriginalName(), 'public');
                $write_file_vi[$key] = $path;
            }
        }
        $write_file_en = [];
        if ($request->hasFile('write_file_en')) {
            $write_file_en = $request->file('write_file_en');
            foreach ($write_file_en as $key => $file) {
                $path = $file->storeAs('lesson-training/write', 'write_' . uniqid() . '_' . $file->getClientOriginalName(), 'public');
                $write_file_en[$key] = $path;
            }
        }

        $exercises_name = $request->exercises_name;
        $answer_1 = $request->answer_1;
        $answer_2 = $request->answer_2;
        $answer_3 = $request->answer_3;
        $answer_4 = $request->answer_4;
        $answer_correct = $request->answer_correct;
        $answer_description = $request->answer_description;

        $id_speak = $request->id_speak;
        $id_write = $request->id_write;
        $id_exercises = $request->id_exercises;

        // act out
        $actOutIdOne = $request->actOutIdOne;
        $actOutIdTwo = $request->actOutIdTwo;
        $actOutNameOne = $request->actOutNameOne;
        $actOutNameTwo = $request->actOutNameTwo;

        // act out
        $actOutId = $request->actOutId;
        $actOutCharacterId = $request->actOutCharacterId;
        $actOutTimeStart = $request->actOutTimeStart;
        $actOutTimeEnd = $request->actOutTimeEnd;
        $actOutEn = $request->actOutEn;
        $actOutVi = $request->actOutVi;

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

        $avatarOne = $request->characterOneUpload;
        if ($request->hasFile('characterOneUpload') && !isUrl($avatarOne)) {
            // remove old image
            if (!empty($lessonDetail->hasCharacters[0]->image)) {
                if (file_exists('storage/' . $lessonDetail->hasCharacters[0]->image)) {
                    unlink('storage/' . $lessonDetail->hasCharacters[0]->image);
                };
            }
            // upload image
            $path = $request->file('characterOneUpload')->store('avatar', 'public');
            $avatarOne = $path;
        }

        $avatarTwo = $request->characterTwoUpload;
        if ($request->hasFile('characterTwoUpload') && !isUrl($avatarTwo)) {
            // remove old image
            if (!empty($lessonDetail->hasCharacters[1]->image)) {
                if (file_exists('storage/' . $lessonDetail->hasCharacters[1]->image)) {
                    unlink('storage/' . $lessonDetail->hasCharacters[1]->image);
                };
            }
            // upload image
            $path = $request->file('characterTwoUpload')->store('avatar', 'public');
            $avatarTwo = $path;
        }

        $videoIds = array(
            'grammar' => explode(',', $videoGrammarIds),
            'lesson' => explode(',', $videoLessonIds),
        );

        if (empty($thumbVal)) {
            $dataLesson = [
                'name' => $name,
                'description' => $description,
                'position' => $position,
                'video_ids' => json_encode($videoIds),
                'level_id' => $level_id,
                'course_id' => $course_id,
                'status' => $status,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
                'created_at' => \Carbon\Carbon::now(),
            ];
        } else {
            $dataLesson = [
                'name' => $name,
                'description' => $description,
                'thumb_img' => $thumbVal,
                'position' => $position,
                'video_ids' => json_encode($videoIds),
                'level_id' => $level_id,
                'course_id' => $course_id,
                'status' => $status,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
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
                    'file_vi' => array_key_exists($index, $speak_file_vi) ? $speak_file_vi[$index] : null,
                    'file_en' => array_key_exists($index, $speak_file_en) ? $speak_file_en[$index] : null,
                    'type' => config('common.lesson_training_types.speaking'),
                    'lesson_id' => $lessonId,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
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
                    'file_vi' => array_key_exists($index, $write_file_vi) ? $write_file_vi[$index] : null,
                    'file_en' => array_key_exists($index, $write_file_en) ? $write_file_en[$index] : null,
                    'type' => config('common.lesson_training_types.writing'),
                    'lesson_id' => $lessonId,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
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
                    'description' => $answer_description[$index],
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                    'created_at' => \Carbon\Carbon::now(),
                ];

                if ($id > 0) {
                    Exercises::where('id', $id)->update($dataExercises);
                } else {
                    Exercises::insert($dataExercises);
                }
            }

            // update act out
            if (!empty($actOutId)) {
                foreach ($actOutId as $index => $id) {
                    $dataActOut = [
                        'lesson_id' => $lessonId,
                        'time_start' => $actOutTimeStart[$index],
                        'time_end' => $actOutTimeEnd[$index],
                        'en' => $actOutEn[$index],
                        'vi' => $actOutVi[$index],
                        'characterId' => $actOutCharacterId[$index],
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id,
                        //'created_at' => \Carbon\Carbon::now(),
                        //'updated_at' => \Carbon\Carbon::now(),
                    ];

                    if ($id > 0) {
                        $dataActOut['updated_at'] = \Carbon\Carbon::now();
                        ActOut::where('id', $id)->update($dataActOut);
                    } else {
                        $dataActOut['created_at'] = \Carbon\Carbon::now();
                        ActOut::insert($dataActOut);
                    }
                }
            }

            if (!empty($avatarOne)) {
                $dataCharacterOne = [
                    'characterName' => $actOutNameOne,
                    'image' => $avatarOne,
                    'created_at' => \Carbon\Carbon::now(),
                ];
            } else {
                $dataCharacterOne = [
                    'characterName' => $actOutNameOne,
                    'created_at' => \Carbon\Carbon::now(),
                ];
            }

            if (!empty($avatarTwo)) {
                $dataCharacterTwo = [
                    'characterName' => $actOutNameTwo,
                    'image' => $avatarTwo,
                    'created_at' => \Carbon\Carbon::now(),
                ];
            } else {
                $dataCharacterTwo = [
                    'characterName' => $actOutNameTwo,
                    'created_at' => \Carbon\Carbon::now(),
                ];
            }

            if ((int)$actOutIdOne > 0) {
                ActOutCharacter::where('id', $actOutIdOne)->update($dataCharacterOne);
            } else {
                $dataCharacter = array(
                    'lesson_id' => $lessonId,
                    'characterId' => 1,
                    'characterName' => $actOutNameOne,
                    'image' => $avatarOne,
                    'created_at' => \Carbon\Carbon::now(),
                );
                ActOutCharacter::insert($dataCharacter);
            }

            if ((int)$actOutIdTwo > 0) {
                ActOutCharacter::where('id', $actOutIdTwo)->update($dataCharacterTwo);
            } else {
                $dataCharacter = [
                    'lesson_id' => $lessonId,
                    'characterId' => 2,
                    'characterName' => $actOutNameTwo,
                    'image' => $avatarTwo,
                    'created_at' => \Carbon\Carbon::now(),
                ];
                ActOutCharacter::insert($dataCharacter);
            }
        }

        return redirect()->route('admin.lesson.index')->with($update > 0 ? SUCCESS : ERROR, $update > 0 ? UPDATE_SUCCESS : UPDATE_ERROR);
    }

    public function deleteActOut(Request $request)
    {
        $lessonId = $request->lessonId;
        if ($lessonId > 0) {
            ActOut::where('lesson_id', $lessonId)->delete();
            return response()->json([
                'msg' => 'Xóa Act Out thành công',
            ]);
        }

        return response()->json([
            'error' => 'Xóa Act Out không thành công',
        ], 404);
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

    public function preview(Request $request)
    {
        $parser = new Parser();
        if ($request->hasFile('file_sub_en') || $request->hasFile('file_sub_vi')) {
            $fileEn = $request->file('file_sub_en');
            $fileVi = $request->file('file_sub_vi');

            $subtitlesEn = null;
            $subtitlesVi = null;

            if ($fileEn != null && $fileEn->path() != null) {
                $parser->loadFile($fileEn->path());
                $subtitlesEn = $parser->parse();
            }

            if ($fileVi != null && $fileVi->path() != null) {
                $parser->loadFile($fileVi->path());
                $subtitlesVi = $parser->parse();
            }

            /*return response()->json([
                'subtitles' => $subtitlesEn,
            ]);*/

            $jsonData = [];

            if (!empty($subtitlesEn) && !empty($subtitlesVi)) {
                foreach ($subtitlesEn as $index => $value) {
                    $jsonData[] = array(
                        'startTime' => $value->startTime,
                        'endTime' => $value->endTime,
                        'en' => $value->text,
                        'vi' => $subtitlesVi[$index]->text
                    );
                }
            } else if (!empty($subtitlesEn)) {
                foreach ($subtitlesEn as $index => $value) {
                    $jsonData[] = array(
                        'startTime' => $value->startTime,
                        'endTime' => $value->endTime,
                        'en' => $value->text,
                        'vi' => ''
                    );
                }
            } else if (!empty($subtitlesVi)) {
                foreach ($subtitlesVi as $index => $value) {
                    $jsonData[] = array(
                        'startTime' => $value->startTime,
                        'endTime' => $value->endTime,
                        'en' => '',
                        'vi' => $value->text
                    );
                }
            } else {
                return 'No Data.';
            }

            $jsonSub['subtitles'] = $jsonData;
            return json_encode($jsonSub);
        } else {
            return 'file_sub not found.';
        }
    }

    public function refreshLessonTraining(Request $request)
    {
        dd($request->all());
    }
}
