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
    ];

    // public function setSlugAttribute($value) {
    //     dd($value);
    //     $this->attributes['slug'] = Str::slug(mb_substr($this->category, 0, 60) . "-", "-");
    //     $double = Category::where('slug', $this->attributes['slug'])->first();

    //     if ($double) {
    //         $next_id = Category::select('id')->orderby('id', 'desc')->first()['id'];
    //         $this->attributes['slug'] .= '-' . ++$next_id;
    //     }
    // }

    

    public function children() {
        return $this->hasMany(Category::class, 'category_id');
    }

    public function parents() {
        return $this->belongsTo('App\Category', 'category_id', 'id');        
    }

    public function products() {
        return $this->hasMany(Product::class);
    }
    
    public function properties() {
        return $this->belongsToMany(Property::class);
    }
}
