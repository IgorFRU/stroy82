<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    public $timestamps = false;

    protected $fillable = ['email', 'description'];

    public function vendors() {
        return $this->hasOne('App\Vendor');
    }
}
