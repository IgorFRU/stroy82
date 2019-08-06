<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    public $timestamps = false;
    
    protected $fillable = ['vendor', 'address', 'site', 'description', 'email', 'phone', 'price_name', 'delivery_time'];
}


