<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageProduct extends Model
{
    public $timestamps = false;

    protected $fillable = ['image_id', 'product_id'];
}
