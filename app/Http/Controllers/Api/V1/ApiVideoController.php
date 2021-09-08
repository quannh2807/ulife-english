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
use Illuminate\Support\Facades\DB;

class ApiVideoController extends BaseApiController
{
    public function videoList(Request $request)
    {
        $checkToken = $this->checkJwt($request->bearerToken());
        $catIds = isset($_GET["cat_ids"]) ? $_GET["cat_ids"] : '';
        $pageSize = isset($_GET["page_size"]) ? (int)$_GET["page_size"] : PAGE_SIZE;
        $pageNumber = isset($_GET["page_number"]) ? (int)$_GET["page_number"] : 0;;
        $sortById = isset($_GET["sortById"]) ? $_GET["sortById"] : '';
        $sortByPosition = isset($_GET["sortByPosition"]) ? $_GET["sortByPosition"] : '';
        $searchText = isset($_GET["search_text"]) ? $_GET["search_text"] : '';
        $topicId = isset($_GET["topic_id"]) ? (int)$_GET["topic_id"] : '';
        $type = isset($_GET["type"]) ? (int)$_GET["type"] : '';

        $mQuery = Video::join('video_category', 'videos.id', '=', 'video_category.video_id')
            ->join('categories', 'video_category.category_id', '=', 'categories.id');
        $mQuery->select(['videos.id AS video_id',
            'videos.title AS video_title',
            'videos.ytb_id',
            'videos.ytb_thumbnails',
            'videos.description',
            'videos.type',
            'videos.status',
            'videos.topic_id',
            'videos.created_at',
            'video_category.category_id',
            'categories.name AS category_name']);
        $mQuery->where('videos.status', 1);

        if (!empty($searchText)) {
            $mQuery->where('videos.title', 'LIKE', '%' . $searchText . '%');
        }

        if (!empty($topicId)) {
            $mQuery->where('videos.topic_id', $topicId);
        }

        if (!empty($type)) {
            $mQuery->where('videos.type', $type);
        }

        if (!empty($catIds)) {
            $mQuery->whereIn('video_category.category_id', explode(',', $catIds));
        }

        if ($sortByPosition == null) {
            //$mQuery->orderBy('videos.position', 'ASC');
        } else {
            $mQuery->orderBy('videos.position', $sortByPosition);
        }

        if (empty($sortById)) {
            $mQuery->orderBy('videos.id', 'DESC');
        } else {
            $mQuery->orderBy('videos.id', $sortById);
        }

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

        $responseData = [];
        foreach ($data as $key => $value) {
            $responseData [] = [
                'id' => $value->video_id,
                'ytb_id' => $value->ytb_id,
                'title' => $value->video_title,
                'description' => $value->description,
                'ytb_thumbnails' => json_decode($value->ytb_thumbnails),
                'category_id' => $value->category_id,
                'category_name' => $value->category_name,
                'type' => $value->type,
                'status' => $value->status,
                'topic_id' => $value->topic_id,
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
            'records' => count($data),
            'total_record' => $totalRecord
        ], 200);
    }

    // video detail by id
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
