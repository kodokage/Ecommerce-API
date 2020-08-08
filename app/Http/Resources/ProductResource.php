<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'business_name' => $this->business_name,
            'description' => $this->description,
            'category' => $this->category,
            'unit_price' => $this->unit_price,
            'max_unit' => $this->max_unit,
            'min_unit' => $this->min_unit,
            'quantity' => $this->quantity,
            'img1'  => asset('product_image/'.$this->img1),
            'img2'  => asset('product_image/'.$this->img2),
            'img3'  => asset('product_image/'.$this->img3),
            ];
    }
}
