<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Propertyvalue extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'value',
        'property_id',
    ];

    public function categories() {
        return $this->belongsTo(Property::class);
    }
}
