<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

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
        if (!isset($this->id)) {
            $this->attributes['slug'] = Str::slug(mb_substr($this->product, 0, 60), "-");
            if (isset($this->attributes['scu'])) {
                $this->attributes['slug'] .= '-' . Str::slug(mb_substr($this->attributes['scu'], 0, 10), "-");
            }        
            $double = Product::where('slug', $this->attributes['slug'])->first();

            if ($double) {
                $next_id = Product::select('id')->orderby('id', 'desc')->first()['id'];
                $this->attributes['slug'] .= '-' . ++$next_id;
            }
        }
        
    }

    public function setAutoscuAttribute($value) {
        if (!isset($this->id)) {
            $this->attributes['autoscu'] = mt_rand(100, 999) . '-' . mt_rand(100, 999);
            while (Product::where('autoscu', $this->attributes['autoscu'])->count() > 0 ) {
                $this->attributes['autoscu'] = mt_rand(100, 999) . '-' . mt_rand(100, 999);
            }
        }
    }

    public function setPriceAttribute($value) {
        if ($value > 0) {
            $this->attributes['price'] = preg_replace('~,~', '.', $value);
        } elseif ($value == 0) {
            $this->attributes['price'] = 0;
        }
    }

    public function setUnitInPackageAttribute($value) {
        if ($value > 0) {
            $this->attributes['unit_in_package'] = preg_replace('~,~', '.', $value);
        }
        // } elseif ($value == 0) {
        //     $this->attributes['unit_in_package'] = 0;
        // }
    }

    public function getPriceNumberAttribute() {
        return number_format($this->price, 2, ',', ' ');
    }

    public function getUnitNumberAttribute() {
        return number_format($this->unit_in_package, 3, ',', ' ');
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
    
    public function articles() {
        return $this->belongsToMany(Article::class);
    }
    
    public function sets() {
        return $this->belongsToMany(Set::class);
    }

    public function manufacture() {
        return $this->belongsTo(Manufacture::class);
    }

    public function unit() {
        return $this->belongsTo(Unit::class);
    }

    public function discount() {
        return $this->belongsTo(Discount::class);
    }

    public function images() {
        return $this->belongsToMany(Image::class);
    }

    public function orders() {
        return $this->belongsToMany(Order::class);
    }

    public function cartproducts() {
        return $this->hasMany(Cart::class);
    }

    public function propertyvalue() {
        return $this->hasMany(Propertyvalue::class);
    }

    //проверяет, отмечен ли товар в боковом меню фильтра товаров
    public function getPropertyActiveProductAttribute($property) {
        foreach ($this->propertyvalue as $key => $value) {
            return $value->property_id;
        }
    }

    public function getMainOrFirstImageAttribute($value) {
        foreach ($this->images as $image) {
            if ($image->main) {
                return $this->images->where('main', 1)->first();
            } else {
                return $this->images->first();
            }            
        }
    }

    public function getActuallyDiscountAttribute($value) {
        $today = Carbon::now();
        if (isset($this->discount) && $this->discount->discount_end >= $today) {
            return true;
        } else {
            return false;
        }        
    }

    public function getDiscountPriceAttribute($value) {
        if ($this->discount->type == '%') {
            if ($this->price * $this->discount->numeral <= 0) {
                return 0.01;
            } else {
                return $this->price * $this->discount->numeral;
            }            
        }
        else if ($this->discount->type == 'rub') {
            if ($this->price - $this->discount->value <= 0) {
                return 0.01;
            } else {
                return $this->price - $this->discount->value;
            }
            
            
        }      
    }

    public function geNumberAttribute() {
        return number_format($this, 2, ',', ' ');
    }
}
