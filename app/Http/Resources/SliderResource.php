<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
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
            "title" => $this->slider_name,
            "link" => $this->slider_link,
            "type" => $this->slider_type,
            "slug" => $this->slider_title,
            "image" => [
                "mobile" => [
                    "url" => "public/assets/img/sliders/m" . $this->slider_image,
                    "width" => 480,
                    "height" => 275,
                ],
                "desktop" => [
                    "url" => "public/assets/img/sliders/" . $this->slider_image,
                    "width" => 1800,
                    "height" => 800,
                ],
            ],
        ];
    }
}
