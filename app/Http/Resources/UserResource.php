<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id'            => $this->first()->id,
            'foto'          => $this->first()->foto,
            'name'          => $this->first()->name,
            'email'         => $this->first()->email,
            'isVerified'    => $this->first()->isVerified,
            'phone'         => $this->first()->phone,
            'roles'         => $this->first()->roles,
            'status'        => $this->first()->status,
            // 'device_token'  => $this->first()->device_token,
            'address'       => $this->first()->merchant ? $this->first()->merchant->address : $this->first()->customer->address,
            'long'          => $this->first()->merchant ? $this->first()->merchant->long : $this->first()->customer->long,
            'lat'           => $this->first()->merchant ? $this->first()->merchant->lat : $this->first()->customer->lat,
            'website'       => $this->first()->merchant ? $this->first()->merchant->website : $this->first()->customer->website,
            
            // 'addition'          => $this->first()->merchant ? new CustomerfullResource( $this->first()->merchant ) : new CustomerfullResource( $this->first()->customer ),
        ];
    }
}
