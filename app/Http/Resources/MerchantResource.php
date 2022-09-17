<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MerchantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request); 
        return [
            'id'            => $this->id,
            'foto'          => $this->foto,
            'name'          => $this->name,
            'email'         => $this->email,
            'isVerified'    => $this->isVerified,
            'phone'         => $this->phone,
            'roles'         => $this->roles,
            'status'        => $this->status,
            // 'device_token'  => $this->first()->device_token,
            'address'       => $this->merchant ? $this->merchant->address : null,
            'long'          => $this->merchant ? $this->merchant->long : null,
            'lat'           => $this->merchant ? $this->merchant->lat : null,
            'day_of_birth'           => $this->merchant ? $this->merchant->day_of_birth : null,
            'gender'           => $this->merchant ? $this->merchant->gender : null,
            'min_price'           => $this->merchant ? $this->merchant->min_price : null,
            'max_price'           => $this->merchant ? $this->merchant->max_price : null,
            'website'           => $this->merchant ? $this->merchant->website : null,
            'open_restaurant'           => $this->merchant ? $this->merchant->open_restaurant : null,
            'close_restaurant'           => $this->merchant ? $this->merchant->close_restaurant : null,
            'about'           => $this->merchant ? $this->merchant->about : null,
            
            
            

            
            // 'data'            => $this->first()->merchant ? new CustomerfullResource( $this->first()->merchant ) : new CustomerfullResource( $this->first()->customer ),
        ];
    }
}
