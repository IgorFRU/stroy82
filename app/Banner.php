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

    public function tags() {
        return $this->hasMany(Bannertag::class)->orderBy('priority', 'ASC');
    }

    public function scopePublished($query) {
        return $query->where('published', 1);
    }
}
