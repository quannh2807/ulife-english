<?php
/**
 * Class ApiQuestionController
 * Created by nguyendx.
 * Date: 8/16/21
 */

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Api\BaseApiController;
use App\Models\Question;
use Illuminate\Http\Request;

class ApiQuestionController extends BaseApiController
{
    public function questionList(Request $request)
    {
        $checkToken = $this->checkJwt($request->bearerToken());
        $pageSize = isset($_GET["page_size"]) ? (int)$_GET["page_size"] : PAGE_SIZE;
        $pageNumber = isset($_GET["page_number"]) ? (int)$_GET["page_number"] : 0;
        $sortById = isset($_GET["sortById"]) ? $_GET["sortById"] : '';

        $mQuery = Question::query();
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
                'name_origin' => $value->name_origin,
                'answer_1' => $value->answer_1,
                'answer_2' => $value->answer_2,
                'answer_3' => $value->answer_3,
                'answer_4' => $value->answer_4,
                'answer_correct' => $value->answer_correct,
                'time_start' => $value->time_start,
                'time_end' => $value->time_end,
                'video_id' => $value->video_id,
                'level_id' => $value->level_id,
                'level_type' => $value->level_type,
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
            'total_record' => count(Question::where('status', 1)->get())
        ], 200);
    }

    public function questionDetail($id)
    {
        $checkToken = $this->checkJwt($this->getBearerToken());
        $data = Question::where('id', $id)->first();

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

        $responseData = [
            'id' => $data->id,
            'name' => $data->name,
            'name_origin' => $data->name_origin,
            'answer_1' => $data->answer_1,
            'answer_2' => $data->answer_2,
            'answer_3' => $data->answer_3,
            'answer_4' => $data->answer_4,
            'answer_correct' => $data->answer_correct,
            'time_start' => $data->time_start,
            'time_end' => $data->time_end,
            'video_id' => $data->video_id,
            'level_id' => $data->level_id,
            'level_type' => $data->level_type,
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
