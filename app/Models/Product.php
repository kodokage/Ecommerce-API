<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];
    
    protected function user(){
        return $this->belongsTo(User::class);
    }
}
