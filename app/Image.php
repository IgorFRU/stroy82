<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'image',
        'productname',
        'thumbnail',
        'name',
        'alt',
        'main'
    ];

    public function products() {
        return $this->belongsToMany(Product::class);
    }
}
