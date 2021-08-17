<?php
/**
 * Class ApiVideoController
 * Created by nguyendx.
 * Date: 8/16/21
 */

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Api\BaseApiController;
use App\Models\Question;
use App\Models\Video;
use App\Models\VideoSubtitle;
use Illuminate\Http\Request;

class ApiVideoController extends BaseApiController
{
    public function videoList(Request $request)
    {
        $checkToken = $this->checkJwt($request->bearerToken());
        //$catId = isset($_GET["cat_id"]) ? (int)$_GET["cat_id"] : 0;
        $pageSize = isset($_GET["page_size"]) ? (int)$_GET["page_size"] : PAGE_SIZE;
        $pageNumber = isset($_GET["page_number"]) ? (int)$_GET["page_number"] : 0;;
        $sortById = isset($_GET["sortById"]) ? $_GET["sortById"] : '';

        $mQuery = Video::query();
        $mQuery->where('status', 1);
        $mQuery->offset($pageSize * $pageNumber);
        $mQuery->limit($pageSize);
        if (empty($sortById)) {
            $mQuery->orderBy('id', 'DESC');
        } else {
            $mQuery->orderBy('id', $sortById);
        }
        $data = $mQuery->get();

        if ($checkToken != 'success') {
            return $this->jsonResponse([
                'status' => false,
                'code' => 200,
                'message' => $checkToken
            ], 200);
        }

        $responseData = [];
        foreach ($data as $key => $value) {
            $responseData [] = [
                'id' => $value->id,
                'ytb_id' => $value->ytb_id,
                'title' => $value->title,
                'description' => $value->description,
                'ytb_thumbnails' => json_decode($value->ytb_thumbnails),
                'type' => $value->type,
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
            'total_record' => count(Video::where('status', 1)->get())
        ], 200);
    }

    public function videoDetail($id)
    {
        $checkToken = $this->checkJwt($this->getBearerToken());
        $data = Video::where('id', $id)->first();

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

        $subtitlesResponse = [];
        $subtitles = VideoSubtitle::where('video_id', $data->id)->orderByRaw('CAST(time_start as DECIMAL) asc')->get();
        if (!empty($subtitles)) {
            foreach ($subtitles as $key => $value) {
                $subtitlesResponse [] = [
                    'id' => $value->id,
                    'vi' => $value->vi,
                    'en' => $value->en,
                    'time_start' => $value->time_start,
                    'time_end' => $value->time_end,
                    'video_id' => $value->video_id,
                    'status' => $value->status,
                    'created_at' => $value->created_at
                ];
            }
        }

        $subtitlesQuestionResponse = [];
        $subtitlesQuestion = Question::where('video_id', $data->id)->orderByRaw('CAST(time_start as DECIMAL) asc')->get();
        if (!empty($subtitlesQuestion)) {
            foreach ($subtitlesQuestion as $key => $value) {
                $subtitlesQuestionResponse [] = [
                    'id' => $value->id,
                    'name' => $value->name,
                    'name_origin' => $value->name_origin,
                    'answer_1' => $value->answer_1,
                    'answer_2' => $value->answer_2,
                    'answer_3' => $value->answer_3,
                    'answer_4' => $value->answer_4,
                    'answer_correct' => $value->answer_correct,
                    'time_start' => $value->time_start,
                    'time_end' => $value->time_end,
                    'level_type' => $value->level_type,
                    'type' => $value->type,
                    'status' => $value->status,
                    'created_at' => $value->created_at
                ];
            }
        }

        $responseData = [
            'id' => $data->id,
            'ytb_id' => $data->ytb_id,
            'title' => $data->title,
            'description' => $data->description,
            'ytb_thumbnails' => json_decode($data->ytb_thumbnails),
            'subtitles' => $subtitlesResponse,
            'subtitlesQuestion' => $subtitlesQuestionResponse,
            'type' => $data->type,
            'status' => $data->status,
            'created_at' => $data->created_at
        ];

        return $this->jsonResponse([
            'status' => true,
            'code' => 200,
            'message' => '',
            'data' => $responseData
        ], 200);
    }
}
