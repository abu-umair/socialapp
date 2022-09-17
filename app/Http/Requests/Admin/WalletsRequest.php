<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class WalletsRequest extends FormRequest
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
            'customers_id'  =>  'nullable',
            'partners_id'   =>  'nullable',
            'type'          =>  'required|string|in:out,in',
            'by'            =>  'required', //BCA, OVO
            'total'         =>  'required',
            'coolpoin'      =>  'nullable',
                        
        ];
    }
}
