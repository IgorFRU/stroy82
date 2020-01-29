<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPasswordNotification;

use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    // protected $guard = 'user';

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

    public function setPhoneAttribute($value) {
        if (isset($value) && $value != '') {
            $phone = $value;
            $phone = str_replace(array('+','-', '(', ')'), '', $phone);
            if (strlen($phone) == 11) {
                $phone = substr($phone, 1);
            }            
            $this->attributes['phone'] = $phone;
        } else {
            $this->attributes['phone'] = $value;
        }
    }
    
    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function firms() {
        return $this->hasMany(Firm::class);
    }

    public function getFullNameAttribute() {
        if (isset($this->surname)) {
            return (ucfirst($this->surname) . ' ' . ucfirst($this->name));
        } else {
            return ucfirst($this->name);
        }        
    }

    public function getUpNameAttribute() {
        if (isset($this->name)) {
            return ucfirst($this->name);
        } else {
            return false;
        }        
    }

    public function getUpSurnameAttribute() {
        if (isset($this->surname)) {
            return ucfirst($this->surname);
        } else {
            return false;
        }        
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function scopeLast($query, $count)
    {
        return $query->orderBy('id', 'desc')->take($count);
    }

    public function getIsOnlineAttribute() {
        // return Carbon::now()->subMinutes(5)->format('Y-m-d H:i:s');
        if ($this->last_activity > Carbon::now()->subMinutes(5)->format('Y-m-d H:i:s')) {
            return true;
        } else {
            return false;
        }
        
    }
}
