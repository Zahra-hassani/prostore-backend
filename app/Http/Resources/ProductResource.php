<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "name" => $this->name,
            "stock" => $this->stock,
            "price" => $this->price,
            "brand" => $this->productDetails? $this->productDetails->brand:null,
            "category" => $this->productDetails? $this->productDetails->category:null,
            "description" => $this->productDetails? $this->productDetails->description:null,
            "images" => $this->images? $this->images: null
        ];
    }
}
