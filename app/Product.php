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
        'quantity_vendor',
        'profit',
        'profit_type',
        'incomin_price',
        'imported',
    ];

    protected $casts = [
        'imported' => 'boolean',
    ];

    public function setImportedAttribute($value) {
        if ($value == 1) {
            $this->attributes['imported'] = true;
        } else {
            $this->attributes['imported'] = false;
        }
    }

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

    public function getFullSizeAttribute() {
        $size = '';
        if ($this->size_type != '' && $this->size_type != NULL) {
            $size_type = '(' . $this->size_type . ')';
        } else {
            $size_type = '';
        }        
        if ($this->size_l != '' && $this->size_w != NULL) {
            $size .= 'длина: ' . $this->size_l . $size_type . '. ';
        }
        if ($this->size_w != '' && $this->size_l != NULL) {
            $size .= 'ширина: ' . $this->size_w . $size_type . '. ';
        }
        if ($this->size_t != '' && $this->size_t != NULL) {
            $size .= 'толщина: ' . $this->size_t . $size_type . '. ';
        }

        return $size;
    }

    public function getMassNumberAttribute() {
        return number_format($this->mass, 2, ',', ' ');
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

    public function options() {
        return $this->hasMany(Option::class);
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
        return $this->belongsToMany(Order::class)->withPivot('amount', 'price');
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

    public function scopePublished($query) {
        return $query->where('published', 1);
    }

    public function scopeFinaly($query) {
        return $query->where('imported', false);
    }

    public function scopeImported($query) {
        return $query->where('imported', true);
    }

    public function scopePopular($query, $limit) {
        return $query->orderBy('views', 'DESC')->limit($limit);
    }

    public function scopeOrder($query) {
        $sort = (isset($_COOKIE['product_sort'])) ? $sort = $_COOKIE['product_sort'] : $sort = 'default';   
        // dd($sort);
                
        switch ($sort) {
            case 'price_up':
                $sort_column = 'price';
                $sort_order = 'DESC';
                break;
            case 'price_down':
                $sort_column = 'price';
                $sort_order = 'ASC';
                break;
            case 'nameAZ':
                $sort_column = 'product';
                $sort_order = 'ASC';
                break;
            case 'nameZA':
                $sort_column = 'product';
                $sort_order = 'DESC';
                break;
            case 'popular':
                $sort_column = 'views';
                $sort_order = 'DESC';
                break;
            case 'new_up':
                $sort_column = 'id';
                $sort_order = 'DESC';
                break;                
            case 'new_down':
                $sort_column = 'id';
                $sort_order = 'ASC';
                break;
            default:
                $sort_column = 'product';
                $sort_order = 'ASC';
                break;
        }
        return $query->orderBy($sort_column, $sort_order);
    }

    public function getClearDescriptionAttribute() {
        return strip_tags($this->description);
    }
}
