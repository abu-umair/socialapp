<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'user_id'       => $this->id,
            'foto'          => $this->foto,
            'name'          => $this->name,
            'email'         => $this->email,
            'isVerified'    => $this->isVerified,
            'phone'         => $this->phone,
            'roles'         => $this->roles,
            'status'        => $this->status,
            // 'device_token'  => $this->first()->device_token,
            'address'       => $this->customer ? $this->customer->address : null,
            'long'          => $this->customer ? $this->customer->long : null,
            'lat'           => $this->customer ? $this->customer->lat : null,
            'website'       => $this->customer ? $this->customer->website : null,
            // 'service'       => $this->service->first() ? new ServiceResource($this->service) : null,
            'service'       => $this->service->first() ? ServiceResource::collection($this->service) : null,


            


            
            // 'data'            => $this->first()->merchant ? new CustomerfullResource( $this->first()->merchant ) : new CustomerfullResource( $this->first()->customer ),
        ];
    }
}
