<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

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

    public function getLimitTitleAttribute($value) {
        return Str::limit($this->article, 50, '... ');
    }

    public function getStartDateAttribute($value) {
        return Carbon::parse($this->created_at)->locale('ru')->isoFormat('DD MMMM YYYY', 'Do MMMM');
    }
}
