<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OrivoucherRequest extends FormRequest
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
            // 'foto'              => 'nullable|image',
            'name'              => 'required|max:255',
            'foto'              => 'nullable|image',
            'coupon_code'       => 'required|string',
            'start_date'        => 'required|date',
            'end_date'          => 'required|date',
            'min_purchase'      => 'required|integer',
            'description'       => 'nullable|string',
            'discount'          => 'nullable|integer',
            'home'              => 'nullable|max:5|in:on',
            'voucher'           => 'nullable|max:5|in:on',
            'status'            => 'nullable|integer',
            'merchants_id'      => 'required|integer'

        ];
    }
}
