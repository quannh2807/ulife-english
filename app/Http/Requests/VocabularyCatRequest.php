<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VocabularyCatRequest extends FormRequest
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
            'name' => 'Name',
            'description' => 'Mô tả',
            'thumb' => 'Ảnh',
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
            'name' => 'required|min:1|max:191',
            //'thumb' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            'name.required' => 'Tên không được bỏ trống.',
            'name.min' => 'Độ dài tối thiếu là :min ký tự.',
            'name.max' => 'Độ dài tối thiếu là :min ký tự.',

            /*'thumb.required' => 'Vui lòng chọn ảnh.',
            'thumb.image' => 'Bạn chỉ được chọn file ảnh.',
            'thumb.mimes' => 'Chỉ chọn ảnh có định dạng: jpeg,png,jpg,gif.',
            'thumb.max' => 'Dung lượng ảnh tối đa 2048MB.',*/

            'status.required' => 'Vui lòng chọn :attribute.',
            'status.size' => 'Vui lòng chọn :attribute.',
        ];
    }

}
