<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageProduct extends Model
{
    public $timestamps = false;

    protected $fillable = ['image_id', 'product_id'];
    public $table = "image_product";

    public function images() {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }

    public function products() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
