<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FavoriteRequest extends FormRequest
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
            'customers_id' => 'required|integer|exists:adfood_customers,id',
            'merchants_id' => 'required|exists:adfood_merchants,id',
            
        ];
    }
}
