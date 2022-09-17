<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
        'customers_id'  => 'nullable|integer',
        'partners_id'   => 'nullable|integer',
        'drivers_id'    => 'nullable|integer',
        'title'         => 'required|max:255',
        'message'       => 'required|max:255',
            
        ];
    }
}
