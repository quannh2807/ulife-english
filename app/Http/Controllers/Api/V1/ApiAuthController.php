<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\Client as OClient;

class ApiAuthController extends BaseApiController
{
    private $userRepository;

    function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(Request $request)
    {
        $data = $request->all();
        $rules = [
            'acc_name' => 'required|min:2|max:26|unique:App\Models\User,acc_name',
            'full_name' => 'required',
            'email' => 'email|required|unique:App\Models\User,email',
            'password' => 'required|confirmed|min:6|max:20',
            'birthday' => 'required'
        ];
        $messages = [
            'acc_name.required' => 'Tên tài khoản bị bỏ trống',
            'acc_name.unique' => 'Tên tài khoản đã tồn tại',
            'acc_name.min' => 'Tên tài khoản có độ dài tối thiểu 2 ký tự',
            'acc_name.max' => 'Tên tài khoản có độ dài tối đa 26 ký tự',

            'full_name.required' => 'Tên đầy đủ bị bỏ trống',

            'email.required' => 'Email bị bỏ trống',
            'email.email' => 'Email không đúng định dạng (example@domain.com)',
            'email.unique' => 'Email đẫ tồn tại',

            'password.required' => 'Mật khẩu bị bỏ trống',
            'password.confirmed' => 'Mật khẩu phải trùng khớp',
            'password.min' => 'Mật khẩu có độ dài tối thiểu 6 ký tự',
            'password.max' => 'Mật khẩu có độ dài đa thiểu 20 ký tự',

            'birthday.required' => 'Tên tài khoản bị bỏ trống',
        ];

        $validation = $this->errorMessages($data, $rules, $messages);

        if ($validation->fails()) {
            $errors = $validation->errors()->messages();
            $errMsg = [];
            foreach ($errors as $key => $error) {
                $errMsg[$key] = $error[0];
            }

            return $this->jsonResponse([
                'status' => false,
                'code' =>  500,
                'message' => 'Đăng ký không thành công, vui lòng kiểm tra lại',
                'errors' => $errMsg,
            ], 500);
        }

        $data['password'] = Hash::make($request->password);
        $data['status'] = 0;

        $user = $this->userRepository->storeNew($data);

        if ($user) {
            return $this->jsonResponse([
                'status' => true,
                'code' =>  200,
                'message' => 'Đăng ký thành công',
            ], 200);
        } else {
            return $this->jsonResponse([
                'status' => false,
                'code' =>  500,
                'message' => 'Đăng ký không thành công, vui lòng kiểm tra lại',
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $data = $request->all();

        $rules = [
            'email' => 'email|required',
            'password' => 'required|min:6|max:20',
        ];
        $messages = [
            'email.required' => 'Email bị bỏ trống',
            'email.email' => 'Email không đúng định dạng (example@domain.com)',

            'password.required' => 'Mật khẩu bị bỏ trống',
            'password.min' => 'Mật khẩu có độ dài tối thiểu 6 ký tự',
            'password.max' => 'Mật khẩu có độ dài đa thiểu 20 ký tự',
        ];
        $validation = $this->errorMessages($data, $rules, $messages);

        if ($validation->fails()) {
            $errors = $validation->errors()->messages();
            $errMsg = [];
            foreach ($errors as $key => $error) {
                $errMsg[$key] = $error[0];
            }

            return $this->jsonResponse([
                'status' => false,
                'code' =>  500,
                'message' => 'Đăng nhập không thành công, vui lòng kiểm tra lại',
                'errors' => $errMsg,
            ], 500);
        }

        if (!Auth::attempt($data)) {
            return $this->jsonResponse([
                'status' => false,
                'code' => 401,
                'message' => 'Không thể đăng nhập, vui lòng kiểm tra lại'
            ], 401);
        }
        $loggedUserId = Auth::id();
        $loggedUser = $this->userRepository->findById($loggedUserId, [], ['id', 'acc_name', 'full_name', 'email', 'birthday', 'phone', 'mobile', 'avatar', 'address', 'status']);
        $loggedUser['avatar'] = 'storage/' . $loggedUser['avatar'];

        $accessToken = Auth::user()->createToken('ulifeAuthToken')->accessToken;

        return $this->jsonResponse([
            'status' => true,
            'code' => 200,
            'message' => 'Đăng nhập thành công',
            'data' => [
                'loggedUser' => $loggedUser,
            ],
            'access_token' => $accessToken,
        ], 200);
        return response(['user' => auth()->user(), 'access_token' => $accessToken]);
    }

    public function getTokenAndRefreshToken($email, $password)
    {
        $oClient = OClient::where('password_client', 1)->where('name', 'ulife-english')->first();

        $response = Http::asForm()->post('localhost:8000/oauth/token', [
            'grant_type' => 'password',
            'client_id' => $oClient->id,
            'client_secret' => $oClient->secret,
            'username' => $email,
            'password' => $password,
            'scope' => '*',
        ]);

        $result = json_decode((string) $response->getBody(), true);
        return response()->json($result, $this->successStatus);
    }
}
