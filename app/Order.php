<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'number',
        'orderstatus_id',
        'payment_method',   // enum('online', 'on delivery')
        'successful_payment',
        'completed'
    ];

    public function statuses() {
        return $this->belongsTo(Orderstatus::class);
    }

    public function products() {
        return $this->belongsToMany(Product::class);
    }

    public function consumers() {
        return $this->belongsToMany(Consumer::class);
    }

    public function statuschangehistories() {
        return $this->hasMany(Statuschangehistory::class);
    }
}
