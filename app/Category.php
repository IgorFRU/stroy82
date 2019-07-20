<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'category', 
        'category_id', 
        'image', 
        'description', 
        'meta_description', 
        'meta_keywords', 
        'views'
    ];

    public function children() {
        return $this->hasMany(Category::class);
    }

    public function products() {
        return $this->hasMany(Product::class);
    }
}
