<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    public $timestamps = false;

    protected $fillable = ['phone', 'description'];

    public function vendors() {
        return $this->hasOne('App\Vendor');
    }
}
