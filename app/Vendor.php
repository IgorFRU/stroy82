<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = ['vendor', 'address', 'site', 'description', 'email_id', 'phone_id', 'price_name'];

    public function emails() {
        return $this->hasOne('App\Email');
    }

    public function phones() {
        return $this->hasOne('App\Phone');
    }
}
