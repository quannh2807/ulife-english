<?php
/**
 * Class ApiTopicsController
 * Created by nguyendx.
 * Date: 8/16/21
 */

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Api\BaseApiController;
use App\Models\Topics;
use Illuminate\Http\Request;

class ApiTopicsController extends BaseApiController
{
    public function topicsList(Request $request)
    {
        $checkToken = $this->checkJwt($request->bearerToken());
        $pageSize = isset($_GET["page_size"]) ? (int)$_GET["page_size"] : PAGE_SIZE;
        $pageNumber = isset($_GET["page_number"]) ? (int)$_GET["page_number"] : 0;
        $searchText = isset($_GET["search_text"]) ? $_GET["search_text"] : '';
        $ids = isset($_GET["ids"]) ? $_GET["ids"] : '';

        $mQuery = Topics::query();
        if (!empty($searchText)) {
            $mQuery->where('name', 'LIKE', '%' . $searchText . '%');
        }
        if (!empty($ids)) {
            $mQuery->whereIn('id', explode(',', $ids));
        }
        $mQuery->where('status', 1);
        $totalRecord = count($mQuery->get());

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
                'level_id' => $value->level_id,
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
            'total_record' => $totalRecord
        ], 200);
    }

    public function topicsDetail($id)
    {
        $checkToken = $this->checkJwt($this->getBearerToken());

        $data = Topics::where('id', $id)->first();

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
            'level_id' => $data->level_id,
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
