<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkRequest extends FormRequest
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
            'category_name' => 'required|max:255',
            'work_time' => 'nullable|integer|min:0',
            'content' => 'nullable',
            'work_date' => 'required|date',
            'weather' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:5120',
        ];
    }
}
