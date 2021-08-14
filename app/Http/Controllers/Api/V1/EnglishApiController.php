<?php
/**
 * Class EnglishApiController
 * Created by nguyendx.
 * Date: 7/22/21
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Levels;
use App\Models\Topics;
use App\Models\Video;
use App\Models\Vocabulary;
use App\Models\VocabularyCat;
use Illuminate\Http\Request;

class EnglishApiController extends Controller
{
    private $secret_key = 'HOvMgMDQ256jybfFokYt1kAokxtxXEA0mgy';

    public function __construct()
    {
    }

    public function vocabularyCatList(Request $request)
    {
        $data = VocabularyCat::where('status', 1)->get();
        if (!$data) {
            return response()->json([
                'status' => false,
                'code' => 200,
                'message' => 'No Data'
            ], 200);
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
                'code' => 200,
                'message' => 'No Data'
            ], 200);
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
                'code' => 200,
                'message' => 'No Data'
            ], 200);
        }
        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => '',
            'data' => $data->toArray()
        ], 200);
    }

    public function courseList(Request $request)
    {
        $token = $request->bearerToken();

        if (!empty($token)) {
            if ($token == $this->secret_key) {
                $data = Course::where('status', 1)->get();
                if (!$data) {
                    return response()->json([
                        'status' => false,
                        'code' => 200,
                        'message' => 'No Data'
                    ], 200);
                }
                return response()->json([
                    'status' => true,
                    'code' => 200,
                    'message' => '',
                    'data' => $data->toArray()
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'code' => 200,
                    'message' => 'Authorization is empty.'
                ], 200);
            }
        } else {
            return response()->json([
                'status' => false,
                'code' => 200,
                'message' => 'Authorization not invalid.'
            ], 200);
        }
    }

    public function lessonList(Request $request)
    {
        $token = $request->bearerToken();

        if (!empty($token)) {
            if ($token == $this->secret_key) {
                $data = Lesson::where('status', 1)->get();
                if (!$data) {
                    return response()->json([
                        'status' => false,
                        'code' => 200,
                        'message' => 'No Data'
                    ], 200);
                }
                return response()->json([
                    'status' => true,
                    'code' => 200,
                    'message' => '',
                    'data' => $data->toArray()
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'code' => 200,
                    'message' => 'Authorization is empty.'
                ], 200);
            }
        } else {
            return response()->json([
                'status' => false,
                'code' => 200,
                'message' => 'Authorization not invalid.'
            ], 200);
        }
    }

    public function levelList(Request $request)
    {
        $token = $request->bearerToken();

        if (!empty($token)) {
            if ($token == $this->secret_key) {
                $data = Levels::where('status', 1)->get();
                if (!$data) {
                    return response()->json([
                        'status' => false,
                        'code' => 200,
                        'message' => 'No Data'
                    ], 200);
                }
                return response()->json([
                    'status' => true,
                    'code' => 200,
                    'message' => '',
                    'data' => $data->toArray()
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'code' => 200,
                    'message' => 'Authorization is empty.'
                ], 200);
            }
        } else {
            return response()->json([
                'status' => false,
                'code' => 200,
                'message' => 'Authorization not invalid.'
            ], 200);
        }
    }

    public function videoList(Request $request)
    {
        //$header = $request->header('token');
        $token = $request->bearerToken();

        if (!empty($token)) {
            if ($token == $this->secret_key) {
                $data = Video::where('status', 1)->get();
                if (!$data) {
                    return response()->json([
                        'status' => false,
                        'code' => 200,
                        'message' => 'No Data'
                    ], 200);
                }
                return response()->json([
                    'status' => true,
                    'code' => 200,
                    'message' => '',
                    'data' => $data->toArray()
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'code' => 200,
                    'message' => 'Authorization is empty.'
                ], 200);
            }
        } else {
            return response()->json([
                'status' => false,
                'code' => 200,
                'message' => 'Authorization not invalid.'
            ], 200);
        }
    }

}
