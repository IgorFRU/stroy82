<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title', 
        'description',
        'link', 
        'image', 
        'published',
    ];

    public function scopePublished($query) {
        return $query->where('published', 1);
    }
}
