<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manufacture extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'manufacture',
        'country',
        'image',
        'description',
        'meta_description',
        'meta_keywords'
    ];

    public function products() {
        return $this->hasMany(Product::class);
    }
}
