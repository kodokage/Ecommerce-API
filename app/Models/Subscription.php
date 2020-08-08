<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $guarded = [];
    
    protected function user()
    {
        return $this->belongsTo(User::class);
    }
}
