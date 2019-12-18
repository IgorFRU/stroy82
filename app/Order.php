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

    public function statuses() {
        return $this->belongsTo(Orderstatus::class);
    }

    public function products() {
        return $this->belongsToMany(Product::class);
    }

    public function consumers() {
        return $this->belongsToMany(Consumer::class);
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
        return $summ;
    }

    public function scopeUnread($query)
    {
        return $query->orderBy('id', 'desc')->where('read_at', '');
    }

    public function scopeLast($query, $count)
    {
        return $query->orderBy('id', 'desc')->take($count);
    }
}
