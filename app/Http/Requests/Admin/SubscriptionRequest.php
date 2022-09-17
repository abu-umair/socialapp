<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionRequest extends FormRequest
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
            'foto'              => 'nullable|image',
            'category'          => 'required|max:255',
            'price'             => 'required|integer',
            'price_discount'    => 'nullable|integer',
            'extra_posts'       => 'nullable|integer',
            'extra_images'      => 'nullable|integer',
            'weeks'             => 'nullable|integer',
            'status'            => 'nullable|integer',
        ];
    }
}
