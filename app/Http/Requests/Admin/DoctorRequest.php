<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DoctorRequest extends FormRequest
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
            'foto' => 'image',
            'name' => 'required|max:255',
            'kategori' => 'required|max:255',
            'lokasi' => 'required',
            'lat' => 'required',
            'long' => 'required',
            'transaksi' => 'required|integer',
            'harga' => 'required|integer',
            'pengalaman' => 'required|max:255',
            'jangka' => 'required|max:50',
            'status' =>'required',
            'tentang' =>'required',
            'layanan.*' => 'required',
        ];
    }
}
