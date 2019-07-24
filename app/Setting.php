<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'site_name',
        'address',
        'phone_1',
        'phone_2',
        'email',
        'viber',
        'whatsapp',
        'vkontakte',
        'main_text'
    ];
}
