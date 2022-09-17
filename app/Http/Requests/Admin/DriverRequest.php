<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DriverRequest extends FormRequest
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
            'partners_id'       =>  'required|exists:coolze_partners,id',
            'foto'              =>  'nullable|image',
            // 'no_anggota'        =>  'required|string',
            'tarif'             =>  'required',
            'long'              =>  'required',
            'lat'               =>  'required',      
            'alamat'            =>  'nullable', 
            'name'              => 'required|max:255',
            'email'             => 'required|max:255',
            'phone'             => 'required',
            // 'email_verified_at' => 'required|max:255',
            'isVerified'        => 'nullable|max:255',            
            'password'          => 'nullable|string|min:6|confirmed',
            'roles'             => 'required|max:30',
            'confirm'           => 'nullable|max:5',  
        ];
    }
}
