<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class VoucherRequest extends FormRequest
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
            'price'             => 'required',
            'name'              => 'required|max:255',
            'expired_at'        => 'required|date',
            'expired_at_time'   => 'nullable',
            'home'              => 'nullable|max:5|in:on',
            'voucher'           => 'nullable|max:5|in:on',
            'used'              => 'nullable',
            'type'              => 'required',
            'coupon_code'       => 'required|string',
            'min_purchase'      => 'required|integer',
            'description'       => 'nullable|string',
            'discount'          => 'nullable|integer',
            'merchants_id'      => 'required|integer'

        ];
    }
}
