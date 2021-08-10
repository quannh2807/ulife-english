<?php
/**
 * Class EnglishApiController
 * Created by nguyendx.
 * Date: 7/22/21
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Topics;
use App\Models\Vocabulary;
use App\Models\VocabularyCat;
use Illuminate\Http\Request;

class EnglishApiController extends Controller
{

    public function __construct()
    {
    }

    public function vocabularyCatList(Request $request)
    {
        $data = VocabularyCat::where('status', 1)->get();
        if (!$data) {
            return response()->json([
                'status' => false,
                'code' => 400,
                'message' => 'No Data'
            ], 400);
        }
        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => '',
            'data' => $data->toArray()
        ], 200);
    }

    public function vocabularyList(Request $request)
    {
        $data = Vocabulary::where('status', 1)->get();
        if (!$data) {
            return response()->json([
                'status' => false,
                'code' => 400,
                'message' => 'No Data'
            ], 400);
        }
        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => '',
            'data' => $data->toArray()
        ], 200);
    }

    public function topicsList(Request $request)
    {
        $data = Topics::where('status', 1)->get();
        if (!$data) {
            return response()->json([
                'status' => false,
                'code' => 400,
                'message' => 'No Data'
            ], 400);
        }
        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => '',
            'data' => $data->toArray()
        ], 200);
    }

}
