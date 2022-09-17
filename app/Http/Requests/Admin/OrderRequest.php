<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
        'customers_id'     => 'required|integer',
        'partners_id'      => 'required|integer',
        'drivers_id'       => 'required|integer',
        'vouchers_id'      => 'nullable|integer',
        'packages_id'      => 'required|integer',
        'subpackages_id'   => 'required|integer',
        'merk'             => 'required|string',
        'qty'              => 'required|integer',
        'date'             => 'required|date',
        'end_date'         => 'required|date',
        'time'             => 'required',
        'status'           => 'required|string',
        // 'acc'              => 'required|integer',
        'rate'             => 'nullable|integer',
        'ulasan_rate'      => 'nullable|max:255',
        'isreviewed'       => 'nullable',
            
        ];
    }
}
