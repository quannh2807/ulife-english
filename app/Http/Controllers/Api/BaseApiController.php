<?php
/**
 * Class BaseApiController
 * Created by nguyendx.
 * Date: 8/16/21
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BaseApiController extends Controller
{
    private $jwtToken = 'eyJhbGciOiJIUzI1NiIsInR5cGUiOiJKV1QiLCJuYW1lIjoiVWxpZmUtRW5nbGlzaCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.Bf7LM8Iz33kafspF_6hD9ppHB7GVYokSr5bxh3KVYOA';

    public function __construct()
    {
    }

    public function getBearerToken()
    {
        return request()->bearerToken();
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

    public function jsonResponse($data, $code = 200)
    {
        return response()->json($data, $code,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function errorMessages($input, $rules, $messages)
    {
        return Validator::make($input, $rules, $messages);
    }
}
