<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
     * @return string[]
     */
    public function attributes()
    {
        return [
            'name' => 'danh mục',
            'slug' => 'slug',
            'status' => 'trạng thái',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:191',
            'slug' => 'required|min:2|max:191',
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
            'name.required' => 'Tên :attribute không được bỏ trống',
            'name.min' => 'Độ dài :attribute tối thiếu là :min ký tự',
            'name.max' => 'Độ dài :attribute tối thiếu là :min ký tự',

            'slug.required' => 'Slug không được bỏ trống',
            'slug.min' => 'Độ dài :attribute tối thiếu là :min ký tự',
            'slug.max' => 'Độ dài :attribute tối thiếu là :min ký tự',

            'status.required' => 'Phải chọn :attribute danh mục',
            'status.size' => 'Phải chọn :attribute danh mục',
        ];
    }
}
