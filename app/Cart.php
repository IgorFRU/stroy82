<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'product_id', 
        'quantity',
        'user_id', 
        'user_ip', 
        'session_id',
        'finished'
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
