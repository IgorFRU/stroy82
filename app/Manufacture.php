<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class Manufacture extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'manufacture',
        'slug',
        'country',
        'description',
        'meta_description',
        'meta_keywords',
    ];

    public function setSlugAttribute($value) 
    {
        if (!isset($this->id)) {
            $this->attributes['slug'] = Str::slug(mb_substr($this->manufacture, 0, 60), "-");
            $double = Manufacture::where('slug', $this->attributes['slug'])->first();

            if ($double) {
                $next_id = Manufacture::select('id')->orderby('id', 'desc')->first()['id'];
                $this->attributes['slug'] .= '-' . ++$next_id;
            }
        }
    }

    public function products() 
    {
        return $this->hasMany(Product::class);
    }

}
