<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consumer extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'quick',
        'name',
        'surname',
        'email',
        'phone',
        'address',
        'password'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];
    
    public function orders() {
        return $this->belongsToMany(Order::class);
    }
}
