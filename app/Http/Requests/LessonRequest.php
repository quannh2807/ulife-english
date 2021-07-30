<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
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
            'name' => 'required|min:3|max:191',
            'description' => 'required',
            'status' => 'required',
            'level_id' => 'required|gt:0',
//            'course_id' => 'required',
//            'thumb_img' => 'mimes:jpg,png,jpeg',
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'name.required' => 'Tên bài học không được bỏ trống',
            'name.min'=>'Tên bài học tối thiểu là 3 ký tự',
            'name.max'=>'Tên bài học tối đa là 191 ký tự',

            'description.required' => 'Mô tả bài học không được bỏ trống',

            'status.required' => 'Trạng bài học không được bỏ trống',

            'level_id.required' => 'Cấp độ bài học không được bỏ trống',
            'level_id.gt' => 'Cấp độ bài học không được bỏ trống',

//            'course_id.required' => 'Khóa học không được bỏ trống',
//            'thumb_img.mimes' => 'Ảnh đại diện không đúng định dạng: jpg, png, jpeg',
        ];
    }
}
