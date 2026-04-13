<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    // fillables
    public $fillable= [
        "product_id",
        "brand",
        "category",
        "description"
    ];
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
