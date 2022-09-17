<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
        // 'order_id'                 => 'unique:adfood_reservations,order_id',
        'adfood_merchants_id'      => 'required|integer',
        'adfood_customers_id'      => 'required|integer',
        'jumlah_orang'             => 'required|integer',
        'date'                     => 'required|date',
        'time'                     => 'required',
        'status'                   => 'required|string|in:accepted,pending,rejected',
        // 'acc'                   => 'required|integer',
        'rate'                     => 'nullable|integer',
        'ulasan_rate'              => 'nullable|max:255',
        'isreviewed'               => 'nullable',
        'pothos_coment'            => 'nullable|image',
        ];
    }
}
