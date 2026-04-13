<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //fillables
    public $fillable= [
        "product_id",
        "user_id",
        "rating"
    ];
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

    public function users(){
        return $this->belongsTo(User::class);
    }
}
