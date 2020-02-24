<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'site_name',
        'address',
        'phone_main',
        'phone_add',
        'email',
        'viber',
        'whatsapp',
        'vkontakte',
        'main_text',
        'orderstatus_id'
    ];

    public function getMainPhoneAttribute($value) {
        if ($this->phone_main != NULL || $this->phone_main != '') {
            $phone_number = substr_replace($this->phone_main, ' ', 8, 0);
            $phone_number = substr_replace($phone_number, ' ', 6, 0);
            $phone_number = substr_replace($phone_number, ') ', 3, 0);
            $phone_number = substr_replace($phone_number, ' (', 0, 0);
            return '+7' . $phone_number;
        } else {
            return '';
        }
    }
    
    public function getAddPhoneAttribute($value) {
        if ($this->phone_add != NULL || $this->phone_add != '') {
            $phone_number = substr_replace($this->phone_add, ' ', 8, 0);
            $phone_number = substr_replace($phone_number, ' ', 6, 0);
            $phone_number = substr_replace($phone_number, ') ', 3, 0);
            $phone_number = substr_replace($phone_number, ' (', 0, 0);
            return '+7' . $phone_number;
        } else {
            return '';
        }
    }
}
