<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'product_id', 
        'quantity',
        'user_id', 
        'session_id'
    ];
}