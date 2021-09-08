<?php
/**
 * Class CourseRequest
 * Created by nguyendx.
 * Date: 8/31/21
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            'name' => 'Khóa học',
            'level_id' => 'Level',
            'description' => 'Mô tả',
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
            'name.required' => 'Khóa học không được bỏ trống.',
            'name.min' => 'Độ dài tối thiếu là :min ký tự.',
            'name.max' => 'Độ dài tối thiếu là :min ký tự.',

            'status.required' => 'Vui lòng chọn :attribute.',
            'status.size' => 'Vui lòng chọn :attribute.',
        ];
    }

}
