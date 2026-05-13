<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "product_id" => $this->product->id,
            "product_name" => $this->product->name,
            "user_name" => $this->user->name,
            "user_email" => $this->user->email,
            "comment" => $this->comment,
            "rating" => $this->rating
        ];
    }
}
