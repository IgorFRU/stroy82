<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsumerOrder extends Model
{
    protected $fillable = ['consumer_id', 'order_id'];

    public $timestamps = false;
}
