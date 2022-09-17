<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class WithdrawsRequest extends FormRequest
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
            'partners_id'  => 'required',
            'norek'        => 'required',
            'bukti_tf'     => 'nullable|image',
            'nominal'      => 'required',
            'bank_tujuan'  => 'required',
                        
        ];
    }
}
