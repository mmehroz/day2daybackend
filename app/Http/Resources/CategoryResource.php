<?php

namespace App\Http\Resources;

use App\Models\SubCategory;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            "name" => $this->category_name,
            "slug" => $this->category_slug,
            "icon" => $this->category_icon,
            "image" => $this->category_image,
//            "sub_category" => SubCategoryResource::collection($this->subcategory),
        ];
    }
}
