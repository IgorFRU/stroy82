<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\UserOrderCreated;

use Carbon\Carbon;
use Illuminate\Support\Str;

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
        'last_activity' => 'datetime',
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

    public function getPhoneLastFourAttribute() {
        return substr($this->phone, -4);
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

    public function sendUserOrderCreatedNotification($order, $status, $user) {
        $this->notify(new UserOrderCreated($order, $status, $user));
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

    public function getCreateDMYTAttribute()
    {
        return $this->created_at->locale('ru')->isoFormat('DD MMMM YYYY, H:mm');
    }

    public function getActivityDMYTAttribute()
    {
        $last_activity = $this->last_activity;
        if ($last_activity) {
            return $last_activity->locale('ru')->isoFormat('DD MMMM YYYY, H:mm');
        } else {
            return ;
        }        
    }

    public function getShortAddressAttribute()
    {
        if (strlen($this->address) > 50) {
            return Str::limit($this->address, 20);
        } else {
            return $this->address;
        }
    }
}
