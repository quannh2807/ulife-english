<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VocabularyRequest extends FormRequest
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
            'spelling' => 'Phiên âm',
            'description' => 'Mô tả',
            'thumb' => 'Ảnh',
            'cat_id' => 'Danh mục',
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
            'spelling' => 'required|min:1|max:191',
            'description' => 'required',
            //'thumb' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'cat_id' => 'required|size:1',
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

            'spelling.required' => ':attribute không được bỏ trống.',
            'spelling.min' => 'Độ dài tối thiếu là :min ký tự.',
            'spelling.max' => 'Độ dài tối thiếu là :min ký tự.',

            'description.required' => 'Mô tả không được bỏ trống',

            /*'thumb.image' => 'Bạn chỉ được chọn file ảnh.',
            'thumb.mimes' => 'Chỉ chọn ảnh có định dạng: jpeg,png,jpg,gif.',
            'thumb.max' => 'Dung lượng ảnh tối đa 2048MB.',*/

            'cat_id.required' => 'Vui lòng chọn :attribute.',
            'cat_id.size' => 'Vui lòng chọn :attribute.',

            'status.required' => 'Vui lòng chọn :attribute.',
            'status.size' => 'Vui lòng chọn :attribute.',
        ];
    }

}
