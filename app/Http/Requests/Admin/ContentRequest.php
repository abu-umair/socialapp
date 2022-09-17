<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ContentRequest extends FormRequest
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
            // 'url' => 'max:500000',
            // 'url' => 'nullable|mimes:pdf,zip,doc,docx|max:10000',
            'url' => 'image|nullable',
            'title_banner' => 'max:255|nullable',
            'title' => 'required|max:255',
            'isi' => 'required',
            
        ];
    }
}
