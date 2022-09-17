<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceCustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        
            return [ 
                'service_id'    => $this->id,
                'users_id'      => $this->users_id,
                'desc'          => $this->desc,
                'title'         => $this->title,
                'price'         => $this->price,
                'user'          => [
                                    'id'            => $this->user->id, 
                                    'foto'          => $this->user->foto,
                                    'name'          => $this->user->name,
                                    'email'         => $this->user->email,
                                    'isVerified'    => $this->user->isVerified,
                                    'phone'         => $this->user->phone,
                                    'roles'         => $this->user->roles,
                                    'status'        => $this->user->status,
                                    'address'       => $this->customer->address, 
                                    'website'       => $this->customer->website, 
                                    'long'          => $this->customer->long, 
                                    'lat'           => $this->customer->lat, 
                                    'address'       => $this->customer->address, 
                                    ],
                                   
            ];
        
    }
}
