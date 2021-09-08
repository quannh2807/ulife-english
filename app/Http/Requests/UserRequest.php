<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'acc_name' => 'required|unique:App\Models\User,acc_name',
            'full_name' => 'required',
            'email' => 'required|unique:App\Models\User,email',
            'birthday' => 'required',
            'phone' => 'nullable',
            'mobile' => 'required',
            'avatar' => 'nullable|image',
            'address' => 'nullable',
            'status' => 'required|size:1',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'acc_name.required' => 'Không được bỏ trống tài khoản người dùng',
            'acc_name.unique' => 'tài khoản này đã tồn tại, vui lòng chọn tài khoản khác',

            'full_name.required' => 'Không được bỏ trống tên người dùng',

            'email.required' => 'Không được bỏ trống email',
            'email.unique' => 'Email này đã tồn tại',

            'birthday.required' => 'Không được bỏ trống ngày sinh',

            'mobile.required' => 'Không được bỏ trống số điện thoại di động',

            'avatar.image' => 'Avatar phải là ảnh, có định dạng phù hợp (jpg, jpeg, png, bmp, gif, svg, hoặc webp)',

            'status.required' => 'Chọn trạng thái người dùng',
            'status.size' => 'Chọn trạng thái người dùng',
        ];
    }
}
