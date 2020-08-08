<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'purchased_unit' => $this->purchased_unit,
            'amount' => $this->amount,
            'paystack_ref' => $this->paystack_ref,
            'receipt_upload' => asset('receipt_image/'.$this->receipt_upload),
            // 'status' => $this->status,
            // 'completerd' => $this->completed,
            ];
    }
}
