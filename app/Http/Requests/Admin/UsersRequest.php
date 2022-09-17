<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
{
    /**
     * Determine if the users is authorized to make this request.
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
            'gender'            => 'nullable|in:male,female',
            'day_of_birth'      => 'nullable|date',
            
            // 'email_verified_at' => 'required|max:255',
            'isVerified'        => 'nullable|max:255',            
            'password'          => 'nullable|string|min:6|confirmed',
            'roles'             => 'required|max:30',
            // 'status'            => 'required|integer',
            'address'           => 'required|max:255',
            'long'              => 'required|max:255',
            'lat'               => 'required|max:255',
            'jenis_pengguna'    => 'required|string|in:mitra,customer',
        ];
    }
}
