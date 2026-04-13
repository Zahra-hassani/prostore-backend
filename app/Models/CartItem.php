<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    //fillables
    public $fillable= [
        "product_id",
        "qty",
        "price"
    ];
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
