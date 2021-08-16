<?php
/**
 * Class ApiCourseController
 * Created by nguyendx.
 * Date: 8/16/21
 */

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Api\BaseApiController;
use App\Models\Course;
use Illuminate\Http\Request;

class ApiCourseController extends BaseApiController
{
    public function courseList(Request $request)
    {
        $checkToken = $this->checkJwt($this->getBearerToken());
        $pageSize = isset($_GET["page_size"]) ? (int)$_GET["page_size"] : PAGE_SIZE;
        $pageNumber = isset($_GET["page_number"]) ? (int)$_GET["page_number"] : 0;;

        $mQuery = Course::query();
        $mQuery->where('status', 1);
        $mQuery->offset($pageSize * $pageNumber);
        $mQuery->limit($pageSize);
        $data = $mQuery->orderBy('id', 'DESC')->get();

        if ($checkToken != 'success') {
            return response()->json([
                'status' => false,
                'code' => 200,
                'message' => $checkToken
            ], 200);
        }

        if (!$data) {
            return response()->json([
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
                'description' => $value->description,
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
            'total_record' => count(Course::where('status', 1)->get())
        ], 200);
    }

    public function courseDetail($id)
    {
        $checkToken = $this->checkJwt($this->getBearerToken());

        $data = Course::where('id', $id)->first();

        if ($checkToken != 'success') {
            return response()->json([
                'status' => false,
                'code' => 200,
                'message' => $checkToken
            ], 200);
        }

        if (!$data) {
            return response()->json([
                'status' => false,
                'code' => 200,
                'message' => 'No Data',
                'data' => []
            ], 200);
        }

        $responseData = [
            'id' => $data->id,
            'name' => $data->name,
            'description' => $data->description,
            'level_id' => $data->level_id,
            'thumb_img' => getPathImage($data->thumb_img),
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
