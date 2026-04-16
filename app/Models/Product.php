<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $fillable= [
        "name",
        "stock",
        "price"
    ];
    public function productDetails(){
        return $this->hasOne(ProductDetail::class);
    }

    public function images(){
        return $this->morphMany(Images::class,'imageable');
    }

    public function reviews(){
        return $this->hasMany(Review::class,'product_id');
    }
    public function cartItem(){
        return $this->hasMany(CartItem::class,'product_id');
    }
}
