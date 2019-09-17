<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Firm extends Model
{
    protected $fillable = [
        'inn',
        'user_id',
        'name',
        'ogrn',
        'okpo',
        'index',
        'region',
        'city',
        'street',
        'status',
    ];

    
}
