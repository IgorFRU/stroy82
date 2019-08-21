<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSet extends Model
{
    public $timestamps = false;

    protected $fillable = ['product_id', 'set_id'];
    public $table = "product_set";

    public function sets() {
        return $this->hasOne(Set::class, 'id', 'set_id');
    }

    public function products() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
