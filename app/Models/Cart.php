<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //fillables
    public $fillable =[
        "user_id",
        "cart_item_id"
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function cartItem(){
        return $this->belongsTo(Cart::class,'cart_item_id');
    }
}
