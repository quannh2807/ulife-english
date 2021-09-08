<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
            'name' => 'Nội dung câu hỏi',
            'answer_1' => 'Câu trả lời 1',
            'answer_2' => 'Câu trả lời 2',
            'answer_3' => 'Câu trả lời 3',
            'answer_4' => 'Câu trả lời 4',
            'answer_correct' => 'Câu trả lời đúng',
            'status' => 'Trạng thái',
            'video_id' => 'Video Id',
            'time_start' => 'Thời gian bắt đầu',
            'time_end' => 'Thời gian kết thúc',
            'level_id' => 'Level ID',
            'level_type' => 'Level type',
            'topics_id' => 'Topics ID',
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
            'name' => 'required|min:3|max:191',
            'answer_1' => 'required|min:3|max:191',
            'answer_2' => 'required|min:3|max:191',
            'answer_3' => 'required|min:3|max:191',
            'answer_4' => 'required|min:3|max:191',
            'answer_correct' => 'required|size:1',
            'time_start' => 'date_format:H:i:s.v',
            'time_end' => 'date_format:H:i:s.v|after:time_start',
            'status' => 'required|size:1',
        ];
    }

    public function getValidatorInstance()
    {
        $this->cleanTimeQuestion();
        return parent::getValidatorInstance();
    }

    protected function cleanTimeQuestion()
    {
        if ($this->request->has('time_start') || $this->request->has('time_end')) {
            $this->merge([
                'time_start' => str_replace(',', '.', $this->request->get('time_start')),
                'time_end' => str_replace(',', '.', $this->request->get('time_end'))
            ]);
        }
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => ':attribute không được bỏ trống.',
            'name.min' => 'Độ dài :attribute tối thiếu là :min ký tự.',
            'name.max' => 'Độ dài :attribute tối thiếu là :min ký tự.',

            'answer_1.required' => ':attribute không được bỏ trống.',
            'answer_1.min' => ':attribute không được nhỏ hơn :min ký tự.',
            'answer_1.max' => ':attribute không được lớn hơn :max ký tự.',

            'answer_2.required' => ':attribute không được bỏ trống.',
            'answer_2.min' => ':attribute không được nhỏ hơn :min ký tự.',
            'answer_2.max' => ':attribute không được lớn hơn :max ký tự.',

            'answer_3.required' => ':attribute không được bỏ trống.',
            'answer_3.min' => ':attribute không được nhỏ hơn :min ký tự.',
            'answer_3.max' => ':attribute không được lớn hơn :max ký tự.',

            'answer_4.required' => ':attribute không được bỏ trống.',
            'answer_4.min' => ':attribute không được nhỏ hơn :min ký tự.',
            'answer_4.max' => ':attribute không được lớn hơn :max ký tự.',

            'answer_correct.required' => 'Vui lòng chọn :attribute.',

            'time_start.date_format' => ':attribute chưa nhập đúng định dạng.',
            'time_end.date_format' => ':attribute chưa nhập đúng định dạng.',

            'time_end.after' => 'Thời gian kết thúc phải lớn hơn thời gian bắt đầu.',

            'status.required' => 'Vui lòng chọn :attribute.',
            'status.size' => 'Vui lòng chọn :attribute.',
        ];
    }

}
