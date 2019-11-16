<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Property extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'property',
        'slug',
    ];

    public function setSlugAttribute($value) {
        $this->attributes['slug'] = Str::slug(mb_substr($this->property, 0, 60), "-");        
        $double = Property::where('slug', $this->attributes['slug'])->first();

        if ($double) {
            $this->attributes['slug'] .= '-' . mt_rand(10, 99);
        }
    }    

    public function category() {
        return $this->belongsToMany(Category::class);
    }

    public function propertyvalues() {
        return $this->belongsToMany(Propertyvalue::class);
    }

    public function values() {
        return $this->hasMany(Propertyvalue::class);
    }
}
