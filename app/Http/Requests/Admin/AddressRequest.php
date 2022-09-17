<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            
            'address'       => 'required|max:255',
            'long'          => 'required|max:255',
            'lat'           => 'required|max:255',
            'alamat_utama'  => 'nullable|max:5|in:on'
            
        ];
    }
}
