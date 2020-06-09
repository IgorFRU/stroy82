<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Typeoption extends Model
{
    protected $fillable = [
        'name',
    ];

    public function options() {
        return $this->hasMany(Option::class);
    }
}
