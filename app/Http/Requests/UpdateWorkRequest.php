<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkRequest extends FormRequest
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
            'title' => 'required|max:255',
            'category_name' => 'nullable|max:255',
            'work_time' => 'nullable|integer|min:0',
            'content' => 'nullable',
            'work_date' => 'required|date',
            'weather' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'タイトルは必須です',
            'title.max' => 'タイトルは255文字以内で入力してください',
            'work_time.integer' => '作業時間は半角数字で入力してください',
            'work_time.min' => '作業時間は0以上で入力してください',
            'work_date.required' => '作業日を入力してください',
            'work_date.date' => '正しい日付形式で入力してください',
            'image.image' => '画像ファイルをアップロードしてください',
            'image.max' => '画像ファイルのサイズは2MB以下にしてください',
        ];
    }
}
