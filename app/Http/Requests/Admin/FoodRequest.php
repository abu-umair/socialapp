<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FoodRequest extends FormRequest
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
            'name'              => 'required|max:255',
            'categories_id'     => 'required|integer',
            'price'             => 'required',
            'promo'             => 'nullable',
            'status'            => 'nullable',
            'merchants_id'      => 'required',
            
            
            
        ];
    }
}
