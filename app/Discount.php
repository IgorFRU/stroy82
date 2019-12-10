<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use Illuminate\Support\Str;

class Discount extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'discount',
        'description',
        'discount_start',
        'discount_end',
        'value',
        'type',// enum('%', 'rub')
        'slug',             
    ];
    
    protected $casts = [
        'discount_start' => 'datetime',
        'discount_end' => 'datetime',
    ];

    public function setSlugAttribute($value) {
        if (!isset($this->id)) {
            $this->attributes['slug'] = Str::slug(mb_substr($this->discount, 0, 60), "-");      
            $double = Discount::where('slug', $this->attributes['slug'])->first();

            if ($double) {
                $next_id = Discount::select('id')->orderby('id', 'desc')->first()['id'];
                $this->attributes['slug'] .= '-' . ++$next_id;
            }
        }
        
    }

    // protected $dateFormat = 'U';

    public function product() {
        return $this->hasMany(Product::class);
    }

    // public function setDiscountEndAttribute($value) {
        
               
    // }

    //перевод процентов число, которое умножается на базовую стоимость
    public function getNumeralAttribute() {
        return (100 - $this->value) / 100;
    }

    public function getDMYAttribute() {
        return $this->discount_end->locale('ru')->isoFormat('DD MMMM YYYY', 'Do MMMM');
    }

    public function getStartDMYAttribute() {
        return $this->discount_start->locale('ru')->isoFormat('DD MMMM YYYY', 'Do MMMM');
    }

    public function getPublishedProductsAttribute($value) {
        return $this->product->where('published', '=', 1);
    }

    public function getPricedProductsAttribute($value) {
        return $this->product->where('price', '>', 0);
    }
    
    public function getActualityAttribute($value) {
        $today = Carbon::now();
        return $this->where('discount_end', '>=', $today)->get();
    }

    public function getItActualityAttribute($value) {
        $today = Carbon::now();
        if ($this->discount_start <= $today && $this->discount_end >= $today) {
            return true;
        } else {
            return false;
        }
    }
}
