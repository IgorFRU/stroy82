<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Propertyvalue extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'value',
        'property_id',
        'product_id',
    ];

    public function products() {
        return $this->belongsTo(Product::class);
    }

    public function properties() {
        return $this->belongsTo(Property::class, 'property_id', 'id');
    }

    public function getFilteredProductsAttribute($value) {
        return Product::whereIn('id', $value)->pluck('id');
    }
}
