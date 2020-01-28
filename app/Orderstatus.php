<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orderstatus extends Model
{
    public $timestamps = false;

    protected $fillable = ['orderstatus', 'color', 'icon'];

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function statuschangehistories() {
        return $this->hasMany(Statuschangehistory::class);
    }
}
