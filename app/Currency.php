<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    
    protected $fillable = ['currency', 'currency_rus', 'to_update', 'css_style'];

    public function products() {
        return $this->hasMany(Product::class);
    }

    // public static function count() {
    //     return Currency::get()->count();
    // }
    
    //список курсов валют для вывода на страницах админки и для отправки по этим валютам запросов в ЦБ
    public static function currenciesListToUpdate() {
        // return Currency::lists('currency');
        return Currency::where('to_update', '1')->pluck('currency');
    }

    public function currencyrate() {
        return $this->hasMany(Currencyrate::class)->whereDate('ondate', date('Y-m-d'));
    }
}
