<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    //fillables
    public function product(){
        return $this->morphTo();
    }
}
