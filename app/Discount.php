<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Discount extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'discount',
        'description',
        'discount_start',
        'discount_end',
        'value',
        'type',             // enum('%', 'rub')
    ];
    
    protected $casts = [
        'discount_start' => 'datetime',
        'discount_end' => 'datetime',
    ];

    public function product() {
        return $this->hasMany(Product::class);
    }

    //перевод процентов число, которое умножается на базовую стоимость
    public function getNumeralAttribute() {
        return (100 - $this->value) / 100;
    }

    public function getPublishedProductsAttribute($value) {
        return $this->product->where('published', '=', 1);
    }

    public function getPricedProductsAttribute($value) {
        return $this->product->where('price', '>', 1);
    }
    
    public function getActualityAttribute($value) {
        $today = Carbon::now();
        return $this->where('discount_end', '>=', $today);
    }
}
