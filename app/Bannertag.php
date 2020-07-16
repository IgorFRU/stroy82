<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bannertag extends Model
{
    protected $fillable = [
        'text', 
        'background',
        'color', 
        'priority', 
        'padding',
        'rounded',
        'shadow',
        'banner_id',
    ];

    public function banner() {
        return $this->belongsTo(Banner::class);
    }
}
