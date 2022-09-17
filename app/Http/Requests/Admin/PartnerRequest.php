<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PartnerRequest extends FormRequest
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
            'name'              => 'required|max:255',
            'email'             => 'required|max:255',
            'phone'             => 'required',
            // 'email_verified_at' => 'required|max:255',
            'isVerified'        => 'nullable|max:255',            
            'password'          => 'nullable|string|min:6|confirmed',
            'roles'             => 'required|max:30',
            // 'jenis_pengguna'    => 'string|in:mitra,customer',
            'foto'              => 'image',
        ];
    }
}
