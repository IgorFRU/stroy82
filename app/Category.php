<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'category', 
        'slug',
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

    public function setSlugAttribute($value) {
        $this->attributes['slug'] = Str::slug(mb_substr($this->product_name, 0, 60) . "-", "-");
        $double = Category::where('slug', $this->attributes['slug'])->first();

        if ($double) {
            $next_id = Category::select('id')->orderby('id', 'desc')->first()['id'];
            $this->attributes['slug'] .= '-' . ++$next_id;
        }
    }
}
