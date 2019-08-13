<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    protected $fillable = [
        'article', 
        'slug',
        'image', 
        'description'
    ];

    public function setSlugAttribute($value) {
        $this->attributes['slug'] = Str::slug(mb_substr($this->article, 0, 60), "-");
        $double = Article::where('slug', $this->attributes['slug'])->first();

        if ($double) {
            $next_id = Article::select('id')->orderby('id', 'desc')->first()['id'];
            $this->attributes['slug'] .= '-' . ++$next_id;
        }
    }

    public function products() {
        return $this->belongsToMany(Product::class);
    }
}
