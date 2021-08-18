<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VideoRequestUpdate extends FormRequest
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
            'ytb_id' => 'required',
            //'ytb_id' => 'unique:videos,id,ytb_id,' . $this->video['ytb_id'],
            'title' => 'required',
            /*'description' => 'required',
            'ytb_thumbnails' => 'required',
            'publish_at' => 'required',
            'tags' => 'required',
            'channel_id' => 'required',*/
            'channel_title' => 'required',
            'status' => 'required',
            'type' => 'required',
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
            'ytb_id.required' => 'Đường dẫn video youtube không được bỏ trống.',
            'ytb_id.unique' => 'Đường dẫn video youtube đã tồn tại.',
        ];
    }
}
