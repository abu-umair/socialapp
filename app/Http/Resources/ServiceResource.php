<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
        // if (isset ($this->user) ) {  //relasi ServiceController
        //     return  //get ServiceResource
        //         new CustomerResource($this->user)
        //     ;
        // } else { 
            return [ //get CustomerResource
                'service_id'    => $this->id,
                'users_id'      => $this->users_id,
                'desc'          => $this->desc,
                'title'         => $this->title,
                'price'         => $this->price,
            ];
        // }
        
    }
}
