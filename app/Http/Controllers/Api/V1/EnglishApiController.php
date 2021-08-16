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
use Illuminate\Support\Str;

class EnglishApiController extends Controller
{
    private $jwtToken = 'eyJhbGciOiJIUzI1NiIsInR5cGUiOiJKV1QiLCJuYW1lIjoiVWxpZmUtRW5nbGlzaCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.Bf7LM8Iz33kafspF_6hD9ppHB7GVYokSr5bxh3KVYOA';

    public function __construct()
    {
    }

    public function getBearerToken()
    {
        $token = request()->bearerToken();
        if (Str::startsWith($token, 'Bearer ')) {
            return Str::substr($token, 7);
        }
    }

    public function getBearerTokenHeader()
    {
        $token = $this->header('Authorization', '');
        if (Str::startsWith($token, 'Bearer ')) {
            return Str::substr($token, 7);
        }
    }

    public function checkJwt($authorization)
    {
        $token = '';
        if (!empty($authorization)) {
            if (Str::startsWith($authorization, 'Bearer ')) {
                $token = Str::substr($authorization, 7);
            } else {
                $token = $authorization;
            }
            if ($token == $this->jwtToken) {
                return 'success';
            } else {
                return 'Authorization not invalid.';
            }
        } else {
            return 'Authorization is empty';
        }
    }

    public function vocabularyCatList(Request $request)
    {
        $checkToken = $this->checkJwt($request->bearerToken());

        if ($checkToken != 'success') {
            return response()->json([
                'status' => false,
                'code' => 200,
                'message' => $checkToken
            ], 200);
        }

        $data = VocabularyCat::where('status', 1)->get();
        if (!$data) {
            return response()->json([
                'status' => false,
                'code' => 200,
                'message' => 'No Data',
                'data' => []
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
        $checkToken = $this->checkJwt($request->bearerToken());

        if ($checkToken != 'success') {
            return response()->json([
                'status' => false,
                'code' => 200,
                'message' => $checkToken
            ], 200);
        }

        $data = Vocabulary::where('status', 1)->get();
        if (!$data) {
            return response()->json([
                'status' => false,
                'code' => 200,
                'message' => 'No Data',
                'data' => []
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
        $checkToken = $this->checkJwt($request->bearerToken());

        if ($checkToken != 'success') {
            return response()->json([
                'status' => false,
                'code' => 200,
                'message' => $checkToken
            ], 200);
        }

        $data = Topics::where('status', 1)->get();
        if (!$data) {
            return response()->json([
                'status' => false,
                'code' => 200,
                'message' => 'No Data',
                'data' => []
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
        $checkToken = $this->checkJwt($this->getBearerToken());

        if ($checkToken != 'success') {
            return response()->json([
                'status' => false,
                'code' => 200,
                'message' => $checkToken
            ], 200);
        }

        $data = Course::where('status', 1)->get();
        if (!$data) {
            return response()->json([
                'status' => false,
                'code' => 200,
                'message' => 'No Data',
                'data' => []
            ], 200);
        }

        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => '',
            'data' => $data->toArray()
        ], 200);
    }

    public function lessonList(Request $request)
    {
        $checkToken = $this->checkJwt($request->bearerToken());

        if ($checkToken != 'success') {
            return response()->json([
                'status' => false,
                'code' => 200,
                'message' => $checkToken
            ], 200);
        }

        $data = Lesson::where('status', 1)->get();
        if (!$data) {
            return response()->json([
                'status' => false,
                'code' => 200,
                'message' => 'No Data',
                'data' => []
            ], 200);
        }

        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => '',
            'data' => $data->toArray()
        ], 200);
    }

    public function levelList(Request $request)
    {
        $checkToken = $this->checkJwt($request->bearerToken());

        if ($checkToken != 'success') {
            return response()->json([
                'status' => false,
                'code' => 200,
                'message' => $checkToken
            ], 200);
        }

        $data = Levels::where('status', 1)->get();
        if (!$data) {
            return response()->json([
                'status' => false,
                'code' => 200,
                'message' => 'No Data',
                'data' => []
            ], 200);
        }

        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => '',
            'data' => $data->toArray()
        ], 200);
    }

    public function videoList(Request $request)
    {
        $checkToken = $this->checkJwt($request->bearerToken());

        if ($checkToken != 'success') {
            return response()->json([
                'status' => false,
                'code' => 200,
                'message' => $checkToken
            ], 200);
        }

        $data = Video::where('status', 1)->get();
        if (!$data) {
            return response()->json([
                'status' => false,
                'code' => 200,
                'message' => 'No Data',
                'data' => []
            ], 200);
        }

        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => '',
            'data' => $data->toArray()
        ], 200);
    }

}
