<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'set', 
        'slug',
        'image', 
        'description',
        'meta_description',
        'meta_keywords',
    ];

    public function setSlugAttribute($value) {
        $this->attributes['slug'] = Str::slug(mb_substr($this->set, 0, 60), "-");
        $double = Set::where('slug', $this->attributes['slug'])->first();

        if ($double) {
            $next_id = Set::select('id')->orderby('id', 'desc')->first()['id'];
            $this->attributes['slug'] .= '-' . ++$next_id;
        }
    }

    public function products() {
        return $this->belongsToMany(Product::class);
    }
}
