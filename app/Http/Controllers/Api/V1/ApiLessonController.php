<?php
/**
 * Class ApiLessonController
 * Created by nguyendx.
 * Date: 8/16/21
 */

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Api\BaseApiController;
use App\Models\Exercises;
use App\Models\Lesson;
use App\Models\LessonTraining;
use App\Models\Video;
use Illuminate\Http\Request;

class ApiLessonController extends BaseApiController
{

    public function lessonList(Request $request)
    {
        $checkToken = $this->checkJwt($request->bearerToken());
        $pageSize = isset($_GET["page_size"]) ? (int)$_GET["page_size"] : PAGE_SIZE;
        $pageNumber = isset($_GET["page_number"]) ? (int)$_GET["page_number"] : 0;;

        $mQuery = Lesson::query();
        $mQuery->where('status', 1);
        $mQuery->offset($pageSize * $pageNumber);
        $mQuery->limit($pageSize);
        $data = $mQuery->orderBy('id', 'DESC')->get();

        if ($checkToken != 'success') {
            return $this->jsonResponse([
                'status' => false,
                'code' => 200,
                'message' => $checkToken
            ], 200);
        }

        if (!$data) {
            return $this->jsonResponse([
                'status' => false,
                'code' => 200,
                'message' => 'No Data',
                'data' => []
            ], 200);
        }

        $responseData = [];
        foreach ($data as $key => $value) {
            $responseData [] = [
                'id' => $value->id,
                'name' => $value->name,
                'description' => utf8_encode($value->description),
                'thumb_img' => getPathImage($value->thumb_img),
                'video_ids' => json_decode($value->video_ids),
                'status' => $value->status,
                'created_at' => $value->created_at
            ];
        }

        return $this->jsonResponse([
            'status' => true,
            'code' => 200,
            'message' => '',
            'data' => $responseData,
            'page_size' => $pageSize,
            'page_number' => $pageNumber,
            'total_record' => count(Lesson::where('status', 1)->get())
        ], 200);
    }

    public function lessonCourseList(Request $request)
    {
        $checkToken = $this->checkJwt($request->bearerToken());
        $idCourse = isset($_GET["course_id"]) ? (int)$_GET["course_id"] : 0;
        $sortById = isset($_GET["sortById"]) ? $_GET["sortById"] : '';
        $sortByPosition = isset($_GET["sortByPosition"]) ? $_GET["sortByPosition"] : '';
        $pageSize = isset($_GET["page_size"]) ? (int)$_GET["page_size"] : PAGE_SIZE;
        $pageNumber = isset($_GET["page_number"]) ? (int)$_GET["page_number"] : 0;
        $searchText = isset($_GET["search_text"]) ? $_GET["search_text"] : '';

        $mQuery = Lesson::query();

        if (!empty($searchText)) {
            $mQuery->where('name', 'LIKE', '%' . $searchText . '%');
        }
        if ($idCourse > 0) {
            $mQuery->where('course_id', $idCourse);
        }
        if ($sortByPosition == null) {
            $mQuery->orderBy('position', 'DESC');
        } else {
            $mQuery->orderBy('position', $sortByPosition);
        }
        if (empty($sortById)) {
            $mQuery->orderBy('id', 'DESC');
        } else {
            $mQuery->orderBy('id', $sortById);
        }

        $mQuery->where('status', 1);
        $totalRecord = count($mQuery->get());
        $mQuery->offset($pageSize * $pageNumber);
        $mQuery->limit($pageSize);
        $data = $mQuery->get();

        if ($checkToken != 'success') {
            return $this->jsonResponse([
                'status' => false,
                'code' => 200,
                'message' => $checkToken
            ], 200);
        }

        if (!$data) {
            return $this->jsonResponse([
                'status' => false,
                'code' => 200,
                'message' => 'No Data',
                'data' => []
            ], 200);
        }

        $responseLesson = [];

        foreach ($data as $key => $lesson) {

            $responseVideoGrammar = [];
            $responseVideoLesson = [];
            $responseSpeak = [];
            $responseWrite = [];
            $responseExercises = [];

            $videosIds = json_decode($lesson->video_ids);
            $videoGrammar = Video::whereIn('id', $videosIds->grammar)->where('status', 1)->get();
            $videoLesson = Video::whereIn('id', $videosIds->lesson)->where('status', 1)->get();

            if (!empty($videoGrammar)) {
                foreach ($videoGrammar as $index => $video) {
                    $responseVideoGrammar [] = [
                        'id' => $video->id,
                        'ytb_id' => $video->ytb_id,
                        'title' => $video->title,
                        'description' => $video->description,
                        'ytb_thumbnails' => json_decode($video->ytb_thumbnails),
                        'type' => $video->type,
                        'status' => $video->status,
                        'created_at' => $video->created_at
                    ];
                }
            }

            if (!empty($videoLesson)) {
                foreach ($videoLesson as $index => $video) {
                    $responseVideoLesson [] = [
                        'id' => $video->id,
                        'ytb_id' => $video->ytb_id,
                        'title' => $video->title,
                        'description' => $video->description,
                        'ytb_thumbnails' => json_decode($video->ytb_thumbnails),
                        'type' => $video->type,
                        'status' => $video->status,
                        'created_at' => $video->created_at
                    ];
                }
            }

            $speakingData = LessonTraining::where('status', 1)->where('lesson_id', $lesson->id)->where('type', config('common.lesson_training_types.speaking'))->get();
            if (!empty($speakingData)) {
                foreach ($speakingData as $index => $item) {
                    $responseSpeak [] = [
                        'id' => $item->id,
                        'vi' => $item->vi,
                        'en' => $item->en,
                        'type' => $item->type,
                        'status' => $item->status,
                        'created_at' => $item->created_at
                    ];
                }
            }

            $writingData = LessonTraining::where('status', 1)->where('lesson_id', $lesson->id)->where('type', config('common.lesson_training_types.writing'))->get();
            if (!empty($writingData)) {
                foreach ($writingData as $index => $item) {
                    $responseWrite [] = [
                        'id' => $item->id,
                        'vi' => $item->vi,
                        'en' => $item->en,
                        'type' => $item->type,
                        'status' => $item->status,
                        'created_at' => $item->created_at
                    ];
                }
            }

            $exercisesData = Exercises::where('status', 1)->where('lesson_id', $lesson->id)->get();
            if (!empty($exercisesData)) {
                foreach ($exercisesData as $index => $item) {
                    $responseExercises [] = [
                        'id' => $item->id,
                        'name' => $item->name,
                        'answer_1' => $item->answer_1,
                        'answer_2' => $item->answer_2,
                        'answer_3' => $item->answer_3,
                        'answer_4' => $item->answer_4,
                        'answer_correct' => $item->answer_correct,
                        'answer_correct_text' => getCorrectTextExercises($item),
                        'status' => $item->status,
                        'created_at' => $item->created_at
                    ];
                }
            }

            $responseLesson [] = [
                'id' => $lesson->id,
                'name' => $lesson->name,
                'description' => utf8_encode($lesson->description),
                'thumb_img' => getPathImage($lesson->thumb_img),
                'position' => $lesson->position,
                'videoGrammar' => $responseVideoGrammar,
                'videoLesson' => $responseVideoLesson,
                'speakList' => $responseSpeak,
                'writeList' => $responseWrite,
                'exercisesList' => $responseExercises,
                'status' => $lesson->status,
                'created_at' => $lesson->created_at
            ];
        }

        return $this->jsonResponse([
            'status' => true,
            'code' => 200,
            'message' => '',
            'data' => $responseLesson,
            'page_size' => $pageSize,
            'page_number' => $pageNumber,
            'total_record' => $totalRecord
        ], 200);
    }

}
