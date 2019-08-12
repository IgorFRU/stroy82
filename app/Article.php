<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'article', 
        'slug',
        'image', 
        'description'
    ];

    public function parents() {
        return $this->belongsTo('App\Category', 'category_id', 'id');        
    }
}
