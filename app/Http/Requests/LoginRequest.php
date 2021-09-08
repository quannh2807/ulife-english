<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|min:6|max:20',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email bị bỏ trống',
            'email.email' => 'Email không đúng định dạng (example@domain.com)',

            'password.required' => 'Mật khẩu bị bỏ trống',
            'password.min' => 'Mật khẩu có độ dài tối thiểu 6 ký tự',
            'password.max' => 'Mật khẩu có độ dài đa thiểu 20 ký tự',
        ];
    }
}
