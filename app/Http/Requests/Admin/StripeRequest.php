<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StripeRequest extends FormRequest
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
            'card_information'          => 'nullable|string',
            'date'                      => 'nullable|date',
            'cvc'                       => 'nullable|string',
            'country_region'            => 'nullable|string',
            'zip'                       => 'nullable|string',
            'created'                   => 'nullable|string',
            'id_card'                   => 'nullable|string',
            'livemode'                  => 'nullable|string',
            'type'                      => 'nullable|string',
            'addressLine1'              => 'nullable|string',
            'addressLine2'              => 'nullable|string',
            'brand'                     => 'nullable|string',
            'expMonth'                  => 'nullable|integer',
            'expYear'                   => 'nullable|integer',
            'funding'                   => 'nullable|string',
            'last4'                     => 'nullable|string',
            'number'                    => 'nullable|string',
            'token'                     => 'nullable|string',
            'id_paymentmethod'          => 'nullable|string',
            'merchants_id'              => 'required|exists:adfood_merchants,id',
        ];
    }
}
