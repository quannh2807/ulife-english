<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
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

    public function register()
    {
        return view('auth.register');
    }

    public function saveRegister(RegisterRequest $request)
    {
        $data = $request->except('password_confirmation');

        $data['password'] = Hash::make($request->password);
        $data['status'] = 0;

        User::create($data);

        return redirect()->route('auth.login', [
            'msg' => 'Đăng ký thành công'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
