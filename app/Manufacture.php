<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manufacture extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'manufacture',
        'slug',
        'country',
        'image',
        'description',
        'meta_description',
        'meta_keywords'
    ];

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function setSlugAttribute($value) {
        $this->attributes['slug'] = Str::slug(mb_substr($this->product_name, 0, 60) . "-", "-");
        $double = Manufacture::where('slug', $this->attributes['slug'])->first();

        if ($double) {
            $next_id = Manufacture::select('id')->orderby('id', 'desc')->first()['id'];
            $this->attributes['slug'] .= '-' . ++$next_id;
        }
    }
}
