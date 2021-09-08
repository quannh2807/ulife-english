<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'acc_name' => 'required|min:2|max:26|unique:App\Models\User,acc_name',
            'full_name' => 'required',
            'email' => 'email|required|unique:App\Models\User,email',
            'password' => 'required|confirmed|min:6|max:20',
            'mobile' => 'required',
        ];
    }

    public function messages()
    {
        return [
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

            'mobile.required' => 'Số điện thoại bị bỏ trống',

        ];
    }
}
