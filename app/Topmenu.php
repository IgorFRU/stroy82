<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Topmenu extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'priority',
        'text',
        'slug',
        'published'
    ];

    public function setSlugAttribute($value) {
        if (!isset($this->id)) {
            $this->attributes['slug'] = Str::slug(mb_substr($this->title, 0, 60), "-");      
            $double = Topmenu::where('slug', $this->attributes['slug'])->first();

            if ($double) {
                $next_id = Topmenu::select('id')->orderby('id', 'desc')->first()['id'];
                $this->attributes['slug'] .= '-' . ++$next_id;
            }
        }
        
    }
}
