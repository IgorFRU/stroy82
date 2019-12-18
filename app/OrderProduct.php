<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    public $timestamps = false;

    protected $fillable = ['order_id', 'product_id', 'amount', 'price'];

    public $table = "order_product";

    // public function setAmountAttribute($value) {
    //     $cart = Cart::where([
    //         ['session_id', session('session_id')],
    //         ['product_id', $this->prduct_id],
    //     ])->first();

    //     $this->attributes['amount'] = $cart->quantity;

    //     if ($cart->product->actually_discount) {
    //         $this->attributes['price'] = $cart->product->discount_price;
    //     } else {
    //         $this->attributes['price'] = $cart->product->price;
    //     }
    // }
}
