<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    //fillables
    protected $fillable = [
        "img_url"
    ];
    public function product(){
        return $this->morphTo();
    }
}
