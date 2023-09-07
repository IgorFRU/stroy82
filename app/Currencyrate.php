<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currencyrate extends Model
{
    protected $fillable = ['currency_id', 'value', 'ondate'];

    public $timestamps = false;

    public function currency() {
        return $this->belongsTo(Currency::class);
    }

    public function product() {
        return $this->hasMany(Product::class, 'currency_id');
    }

}
