<?php

namespace App\MyClasses;

use \Carbon\Carbon;
use App\Currency;
use App\Currencyrate;

use Illuminate\Support\Facades\Cache;

class Cbr
{
    static $days = [];
    static $today;
    static $tomorrow;
    static $valute_names = [];
    static $valute_values = [];
    static $valute_values_array = [];
    static $count_valutes;
    static $file;
    static $hour = 60;

    public static function configurate() {
        self::$today = Carbon::now()->format('d.m.Y');
        self::$tomorrow = Carbon::now()->addDay()->format('d.m.Y');

        //выбор валют, которые нуждаются в обновлении курса. Основная валюта только одна и это обычно рубль. Относительно нее все курсы

        //добавить вызов метода, проверяющего, обновлять ли курс для валюты
        self::$valute_names = Cache::remember('valute_names', self::$hour, function() {
            return Currency::currenciesListToUpdate();
        });
        
        self::$count_valutes = sizeof(self::$valute_names);

        // dd(self::$valute_names);

        if (self::$valute_names) {
            self::getCourses(self::$today);
            if (Carbon::now()->format('H') >= '14') {
                self::getCourses(self::$tomorrow);
            }
        } else {
            //dd(self::$valute_names);
            self::$valute_values = 0;
        }
        
        
        //self::isChanged();
    }

    private static function getCourses($day) {        
        // $tmp = Currencyrate::where('ondate', date("Y-m-d", strtotime($day)))->get();
        // dd($tmp[0]->currency->currency);
        if (!Currencyrate::where('ondate', date("Y-m-d", strtotime($day)))->count()) {
            self::$file = simplexml_load_file("http://www.cbr.ru/scripts/XML_daily.asp?date_req=".$day);
            //self::$file = simplexml_load_file($day);
            $content = [];

            foreach (self::$file AS $el){
                $content[strval($el->CharCode)] = strval($el->Value);
            }
        
            for ($j=0; $j < self::$count_valutes; $j++) {
                self::$valute_values = number_format(str_replace(',', '.', $content[self::$valute_names[$j]]), 2, '.', '');
                //dd(self::$valute_values);
                $todatabase['currency_id'] = Currency::where('currency', self::$valute_names[$j])->pluck('id')[0];
                // $todatabase['value'] = end(self::$valute_values);
                $todatabase['value'] = self::$valute_values;
                $todatabase['ondate'] = date("Y-m-d", strtotime($day));
                
                Currencyrate::create($todatabase);
            }
        } else {             
            for ($j=0; $j < self::$count_valutes; $j++) {
                $id = Currency::where('currency', self::$valute_names[$j])->pluck('id')[0];
                
                if ($day == self::$today) {
                    self::$valute_values_array[$id] = Currencyrate::where([
                        ['ondate', date("Y-m-d", strtotime($day))],
                        ['currency_id', $id],
                    ])->pluck('value')[0];
                }
                

                foreach (self::$valute_values_array as $value) {                    
                    self::$valute_values = $value;
                }  

                //dd(key($valute_values_array)) ;
                //self::$valute_values[] =  $valute_values_array;   
            } 
        }
    }

    private function saveCurrencyRate() {

    }

    private static function isChanged() {
        for ($i=0; $i < self::$count_valutes; $i++) { 
            if (self::$valute_values[$i] == self::$valute_values[$i + self::$count_valutes]) {
                self::$valute_values[$i + self::$count_valutes] = -1;
            }
        }
    }
    
    public static function get() {
        self::configurate();
        return self::$valute_values;
    }

    public static function today() {
        self::configurate();
        return Currencyrate::where('ondate', date("Y-m-d", strtotime(self::$today)))->orderBy('currency_id', 'ASC')->get();
    }

    public static function tomorrow() {
        self::configurate();
        return Currencyrate::where('ondate', date("Y-m-d", strtotime(self::$tomorrow)))->orderBy('currency_id', 'ASC')->get();
    }

    public static function getAssociate() {
        self::configurate();
        return self::$valute_values_array;
    }

    public static function getNames() {
        if (count(self::$valute_names) == 0) {
            self::$valute_names = Currency::currenciesListToUpdate();
        }        
        return self::$valute_names;
    }
}
