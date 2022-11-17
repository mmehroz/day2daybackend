<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
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
            "id" => $this->id,
            "coupon_name" => $this->coupon_name,
            "coupon_code" => $this->coupon_code,
            "coupon_discount" => $this->coupon_discount,
            "coupon_validity" => $this->coupon_validity,
            "coupon_type" => $this->coupon_type,
            "coupon_status" => $this->coupon_status,
        ];
    }
}
