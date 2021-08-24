<?php
/**
 * Class ApiCategoryController
 * Created by nguyendx.
 * Date: 8/16/21
 */

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Api\BaseApiController;
use App\Models\Category;
use App\Models\Topics;
use App\Models\Video;
use Illuminate\Http\Request;

class ApiCategoryController extends BaseApiController
{

    public function categoryList(Request $request)
    {
        $checkToken = $this->checkJwt($request->bearerToken());
        $limitVideos = isset($_GET["limit_video"]) ? (int)$_GET["limit_video"] : 5;
        $pageSize = isset($_GET["page_size"]) ? (int)$_GET["page_size"] : PAGE_SIZE;
        $pageNumber = isset($_GET["page_number"]) ? (int)$_GET["page_number"] : 0;
        $sortById = isset($_GET["sortById"]) ? $_GET["sortById"] : '';
        $searchText = isset($_GET["search_text"]) ? $_GET["search_text"] : '';
        $ids = isset($_GET["ids"]) ? $_GET["ids"] : '';

        $mQuery = Category::query();

        if (!empty($searchText)) {
            $mQuery->where('name', 'LIKE', '%' . $searchText . '%');
        }
        if (!empty($ids)) {
            $mQuery->whereIn('id', explode(',', $ids));
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

            $mQuery = Video::join('video_category', 'videos.id', '=', 'video_category.video_id')
                ->join('categories', 'video_category.category_id', '=', 'categories.id');
            $mQuery->select(['videos.id',
                'videos.title',
                'videos.ytb_id',
                'videos.ytb_thumbnails',
                'videos.description',
                'videos.type',
                'videos.status',
                'videos.topic_id',
                'videos.created_at',
                'video_category.category_id',
                'categories.name AS category_name']);

            $mQuery->where('video_category.category_id', $value->id);
            $mQuery->where('videos.status', 1);
            $mQuery->limit($limitVideos);
            $videoData = $mQuery->get();

            $responseData [] = [
                'id' => $value->id,
                'name' => $value->name,
                //'slug' => $value->slug,
                'position' => $value->position,
                'parent_id' => $value->parent_id,
                'videos' => $videoData,
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
            'total_record' => $totalRecord
        ], 200);
    }

    public function categoryDetail($id)
    {
        $checkToken = $this->checkJwt($this->getBearerToken());
        $data = Category::where('id', $id)->first();

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
            'slug' => $data->slug,
            'position' => $data->position,
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

    public function grammarList(Request $request)
    {
        $checkToken = $this->checkJwt($request->bearerToken());
        $limitVideos = isset($_GET["limit_video"]) ? (int)$_GET["limit_video"] : 5;
        $pageSize = isset($_GET["page_size"]) ? (int)$_GET["page_size"] : PAGE_SIZE;
        $pageNumber = isset($_GET["page_number"]) ? (int)$_GET["page_number"] : 0;
        $sortById = isset($_GET["sortById"]) ? $_GET["sortById"] : '';
        $searchText = isset($_GET["search_text"]) ? $_GET["search_text"] : '';
        $ids = isset($_GET["ids"]) ? $_GET["ids"] : '';

        $mQuery = Topics::query();

        if (!empty($searchText)) {
            $mQuery->where('name', 'LIKE', '%' . $searchText . '%');
        }
        if (!empty($ids)) {
            $mQuery->whereIn('id', explode(',', $ids));
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

            $mQuery = Video::join('topics', 'videos.topic_id', '=', 'topics.id');
            $mQuery->select(['videos.id',
                'videos.title',
                'videos.ytb_id',
                'videos.ytb_thumbnails',
                'videos.description',
                'videos.type',
                'videos.status',
                'videos.topic_id',
                'topics.name AS topic_name',
                'topics.status AS topic_status']);

            $mQuery->where('topics.status', 1);
            $mQuery->where('videos.status', 1);
            $mQuery->limit($limitVideos);
            $videoData = $mQuery->get();

            $responseData [] = [
                'id' => $value->id,
                'name' => $value->name,
                //'slug' => $value->slug,
                'position' => $value->position,
                'parent_id' => $value->parent_id,
                'videos' => $videoData,
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
            'total_record' => $totalRecord
        ], 200);
    }
}
