<?php
/**
 * Class ApiVideoController
 * Created by nguyendx.
 * Date: 8/16/21
 */

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Api\BaseApiController;
use App\Models\Video;
use Illuminate\Http\Request;

class ApiVideoController extends BaseApiController
{
    public function videoList(Request $request)
    {
        $checkToken = $this->checkJwt($request->bearerToken());
        $pageSize = isset($_GET["page_size"]) ? (int)$_GET["page_size"] : PAGE_SIZE;
        $pageNumber = isset($_GET["page_number"]) ? (int)$_GET["page_number"] : 0;;

        $mQuery = Video::query();
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

        $responseData = [];
        foreach ($data as $key => $value) {
            $responseData = [
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

        $responseData = [
            'id' => $data->id,
            'ytb_id' => $data->ytb_id,
            'title' => $data->title,
            'description' => $data->description,
            'ytb_thumbnails' => json_decode($data->ytb_thumbnails),
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
