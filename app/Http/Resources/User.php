<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
        'first_name' => $this->first_name,
        'last_name' => $this->last_name,
        'category' => $this->category,
        'status' => $this->status,
        'isAdmin' => $this->isAdmin,
        'blocked' => $this->blocked,
        'gender' => $this->gender,
        'phone' => $this->phone,
        'phone_2' => $this->phone_2,
        'address' => $this->address,
        'nearest_bustop' => $this->nearest_bustop,
        'delivery_bus_park' => $this->delivery_bus_park,
        'business_name' => $this->business_name,
        'image'  => asset('profile_image/'.$this->image),
       // return parent::toArray($request)
        ];
    }
}
