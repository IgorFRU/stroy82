<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'product',
        'product_pricename',
        'slug',
        'scu',
        'autoscu',
        'category_id',
        'manufacture_id',
        'vendor_id',
        'unit_id',
        'discount_id',
        'size_l',
        'size_w',
        'size_t',
        'size_type',
        'mass',
        'short_description',
        'description',
        'delivery_time',
        'meta_description',
        'meta_keywords',
        'published',
        'pay_online',
        'packaging',
        'unit_in_package',
        'amount_in_package',
        'price',
        'quantity',
        'quantity_vendor'
    ];

    public function setSlugAttribute($value) {
        $this->attributes['slug'] = Str::slug(mb_substr($this->product, 0, 60), "-");
        $this->attributes['slug'] .= '-' . Str::slug(mb_substr($this->attributes['scu'], 0, 10), "-");
        $double = Product::where('slug', $this->attributes['slug'])->first();

        if ($double) {
            $next_id = Product::select('id')->orderby('id', 'desc')->first()['id'];
            $this->attributes['slug'] .= '-' . ++$next_id;
        }
    }

    public function setAutoscuAttribute($value) {
        $this->attributes['autoscu'] = mt_rand(100, 999) . '-' . mt_rand(100, 999) . '-' . mt_rand(1000, 9999);
    }

    public function categories() {
        return $this->belongsTo(Category::class);
    }

    public function manufactures() {
        return $this->belongsTo(Manufacture::class);
    }

    public function units() {
        return $this->belongsTo(Unit::class);
    }

    public function discounts() {
        return $this->belongsTo(Discount::class);
    }

    public function images() {
        return $this->belongsToMany(Image::class);
    }

    public function orders() {
        return $this->belongsToMany(Order::class);
    }
}
