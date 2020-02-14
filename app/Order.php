<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\OrderProduct;

class Order extends Model
{
    protected $fillable = [
        'number',
        'orderstatus_id',
        'user_id',
        'firm_inn',
        'payment_method',   // enum('online', 'on delivery')
        'successful_payment',
        'completed'
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function status() {
        return $this->belongsTo(Orderstatus::class, 'orderstatus_id');
    }

    public function products() {
        return $this->belongsToMany(Product::class)->withPivot('amount', 'price');
    }

    public function consumers() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function statuschangehistories() {
        return $this->hasMany(Statuschangehistory::class);
    }

    public function getDMYAttribute() {
        return $this->created_at->locale('ru')->isoFormat('DD MMMM YYYY', 'Do MMMM');
    }

    public function getTotalSummAttribute() {
        $order_product = OrderProduct::where('order_id', $this->id)->get();
        $summ = 0;
        foreach ($order_product as $item) {
            $summ += $item->amount * $item->price;
        }
        return number_format($summ, 2, ',', ' ');
    }

    public function getAmountAttribute($product_id) {
        return OrderProduct::where('order_id', $this->id)->where('product_id', $product_id)->pluck('amount');
    }

    public function scopeUnread($query)
    {
        return $query->orderBy('id', 'desc')->where('read_at', NULL);
    }

    public function scopeUnreadlast($query, $quantity)
    {
        return $query->orderBy('id', 'desc')->where('read_at', NULL)->limit($quantity);
    }

    public function scopeActive($query)
    {
        return $query->orderBy('id', 'desc')->where('completed', 0);
    }

    public function scopeArchive($query)
    {
        return $query->orderBy('id', 'desc')->where('completed', 1);
    }

    public function getUnreadAttribute()
    {
        if ($this->read_at) {
            return false;
        } else {
            return true;
        }        
    }

    public function scopeLast($query, $count)
    {
        return $query->orderBy('id', 'desc')->take($count);
    }

    public function getSummAttribute()
    {
        $products = $this->products;
        // dd($products);
        $summ = 0;
        if ($products) {            
            foreach ($products as $product) {
                $summ += $product->pivot->amount * $product->pivot->price;
            }
        } 
        return number_format($summ, 2, ',', ' ') . ' руб.';        
    }

    public function getReadDMYTAttribute()
    {
        return $this->read_at->locale('ru')->isoFormat('DD MMMM YYYY, H:mm');
    }

    public function getCreateDMYTAttribute()
    {
        return $this->created_at->locale('ru')->isoFormat('DD MMMM YYYY, H:mm');
    }

    public function getCountProductsAttribute()
    {
        return count($this->products);
    }
}
