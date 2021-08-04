<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadSubRequest extends FormRequest
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
            'video_id' => 'required',
            'lang' => 'required',
            'file_upload' => 'required'
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
            'video_id.required' => 'Chọn video cho file upload',

            'lang.required' => 'Chọn ngôn ngữ cho file upload',

            'file_upload.required' => 'Phải chọn file từ máy tính',
            'file_upload.mimes' => 'File phụ đề phải có định dạng .srt',
        ];
    }
}
