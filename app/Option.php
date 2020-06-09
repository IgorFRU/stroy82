<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = [
        'typeoption_id',
        'product_id',
        'option',
        'type',
        'name_plus',
        'scu',
        'autoscu',
        'price',
        'photo',
        'color',
        'main',
    ];
    
    public function type() {
        return $this->belongsTo(Typeoption::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function child() {
        return $this->belongsToMany(Option::class, 'option_optionchild', 'option_id', 'child_id')->withPivot('scu', 'autoscu', 'price')->withTimestamps();
    }

    public function parent() {
        return $this->belongsToMany(Option::class, 'option_optionchild', 'child_id', 'option_id')->withPivot('scu', 'autoscu', 'price')->withTimestamps();
    }
}
