<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $tags = explode(',', $this->product_tags);

        return [
            "id" => $this->id,
            "product_name" => $this->product_name,
            "product_sku" => $this->product_sku,
            "product_slug" => $this->product_slug,
            "product_code" => $this->product_code,
            "product_qty" => $this->product_qty,
            "product_tags" => $tags,
            "purchase_price" => $this->purchase_price,
            "selling_price" => $this->selling_price,
            "discount_price" => $this->discount_price,
            "short_description" => $this->short_description,
            "long_description" => $this->long_description,
            "product_thumbnail" => $this->product_thumbnail,
            "hot_deals" => $this->hot_deals,
            "featured" => $this->featured,
            "new_arrival" => $this->new_arrival,
            "special_offer" => $this->special_offer,
            "special_deals" => $this->special_deals,
            "status" => $this->status,
            "brand" => new BrandResource($this->brand),
//            "category_name" => $this->category->category_name,
//            "category_icon" => $this->category->category_icon,
//            "category_image" => $this->category->category_image,
            "category" => new CategoryResource($this->category),
            "sub_category" => new SubSubCategoryResource($this->subcategory),
            "sub_sub_category" => new SubSubCategoryResource($this->subsubcategory),
            "photos" => $this->photos,
            "variants" => VariantResource::collection($this->variant),
        ];
    }
}
