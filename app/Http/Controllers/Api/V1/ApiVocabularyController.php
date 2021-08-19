<?php
/**
 * Class ApiVocabularyController
 * Created by nguyendx.
 * Date: 8/16/21
 */

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Api\BaseApiController;
use App\Models\Vocabulary;
use App\Models\VocabularyCat;
use Illuminate\Http\Request;

class ApiVocabularyController extends BaseApiController
{

    public function vocabularyList(Request $request)
    {
        $checkToken = $this->checkJwt($request->bearerToken());
        $catId = isset($_GET["cat_id"]) ? (int)$_GET["cat_id"] : 0;
        $pageSize = isset($_GET["page_size"]) ? (int)$_GET["page_size"] : PAGE_SIZE;
        $pageNumber = isset($_GET["page_number"]) ? (int)$_GET["page_number"] : 0;
        $sortById = isset($_GET["sortById"]) ? $_GET["sortById"] : '';
        $searchText = isset($_GET["search_text"]) ? $_GET["search_text"] : '';

        $mQuery = Vocabulary::query();

        if (!empty($searchText)) {
            $mQuery->where('name', 'LIKE', '%' . $searchText . '%');
        }
        if ($catId > 0) {
            $mQuery->where('cat_id', $catId);
        }
        $mQuery->where('status', 1);

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

        $responseData = [];
        foreach ($data as $key => $value) {
            $responseData [] = [
                'id' => $value->id,
                'word' => $value->name,
                'pronounce' => $value->spelling,
                'description' => utf8_encode($value->description),
                'image' => getPathImage($value->thumb),
                //'cat_id' => $value->cat_id,
                'status' => $value->status,
                //'created_at' => $value->created_at
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

    public function vocabularyDetail($id)
    {
        $checkToken = $this->checkJwt($this->getBearerToken());
        $data = Vocabulary::where('id', $id)->first();

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
            'word' => $data->name,
            'pronounce' => $data->spelling,
            'description' => utf8_encode($data->description),
            'thumb' => getPathImage($data->thumb),
            'cat_id' => $data->cat_id,
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

    public function vocabularyCatList(Request $request)
    {
        $checkToken = $this->checkJwt($request->bearerToken());
        $pageSize = isset($_GET["page_size"]) ? (int)$_GET["page_size"] : PAGE_SIZE;
        $pageNumber = isset($_GET["page_number"]) ? (int)$_GET["page_number"] : 0;
        $sortById = isset($_GET["sortById"]) ? $_GET["sortById"] : '';
        $searchText = isset($_GET["search_text"]) ? $_GET["search_text"] : '';

        $mQuery = VocabularyCat::query();

        if (!empty($searchText)) {
            $mQuery->where('name', 'LIKE', '%' . $searchText . '%');
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

        $responseData = [];
        foreach ($data as $key => $value) {
            $responseData [] = [
                'id' => $value->id,
                'title' => $value->name,
                'image' => getPathImage($value->thumb),
                //'description' => utf8_encode($value->description),
                //'parent_id' => $value->parent_id,
                //'type' => $value->type,
                'status' => $value->status,
                //'created_at' => $value->created_at
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

    public function vocabularyCatDetail($id)
    {
        $checkToken = $this->checkJwt($this->getBearerToken());
        $data = VocabularyCat::where('id', $id)->first();

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
            'title' => $data->name,
            'image' => getPathImage($data->thumb),
            'description' => utf8_encode($data->description),
            'parent_id' => $data->parent_id,
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
