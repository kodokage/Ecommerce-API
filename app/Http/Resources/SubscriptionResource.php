<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
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
            'id' => $this->user_id,
            'sub_type' => $this->sub_type,
            'amount' => $this->amount,
            'status' => $this->status,
            'paystack_ref' => $this->paystack_ref,
            'authorized' => $this->authorized,
            'receipt_image'  => asset('subscription_image/'.$this->img1),
        ];
    }
}
