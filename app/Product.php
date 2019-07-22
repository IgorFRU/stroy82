<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product',
        'slug',
        'scu',
        'autoscu',
        'category_id',
        'manufacture_id',
        'vendor_id',
        'unit_id',
        'discount_id',
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
        'price'
    ];

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

    public function setSlugAttribute($value) {
        $this->attributes['slug'] = Str::slug(mb_substr($this->product_name, 0, 60) . "-", "-");
        $this->attributes['slug'] .= '-' . $this->attributes['scu'];
        $double = Product::where('slug', $this->attributes['slug'])->first();

        if ($double) {
            $next_id = Product::select('id')->orderby('id', 'desc')->first()['id'];
            $this->attributes['slug'] .= '-' . ++$next_id;
        }
    }

    public function setAutoscuAttribute($value) {
        $this->attributes['autoscu'] = mt_rand();
        $double = Product::where('autoscu', $this->attributes['autoscu'])->first();

        while ($double > 0) {
            $this->attributes['autoscu'] = mt_rand();
        }
    }
}
