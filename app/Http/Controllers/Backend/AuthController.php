<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function saveLogin(LoginRequest $request)
    {
        $data = $request->except('_token', 'remember_me');

        $remember = false;
        if ($request->remember_me === 'on') {
            $remember = true;
        }
        if (Auth::attempt($data, $remember)) {
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không đúng!',
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->all();

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

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
