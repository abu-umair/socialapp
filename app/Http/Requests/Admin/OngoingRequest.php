<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OngoingRequest extends FormRequest
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
            'customers_id' => 'required|integer',
            'doctors_id'=> 'nullable|integer', 
            'groomers_id' => 'nullable|integer',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'metode_layanan' => 'required|integer',
            'status' => 'required|integer',
            'time_akhir' => 'required|date_format:H:i',
            'masalah_hewan' => '',
            'acc' => 'required|max:255',
            // 'nilai_product'=> 'integer',
            // 'review_product'=> 'max:255',
            // 'isreviewed' => 'required|max:10',

        ];
    }
}
