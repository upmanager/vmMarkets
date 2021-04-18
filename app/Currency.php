<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Currency
{
    public static function makePrice($price)
    {
        $rightSymbol = DB::table('settings')->where('param', '=', "rightSymbol")->get()->first()->value;
        $symbolDigits = DB::table('settings')->where('param', '=', "default_currencyCode")->
            join("currencies", 'currencies.code', '=', 'settings.value')->get()->first()->digits;
        $currency = DB::table('settings')->where('param', '=', "default_currencies")->get()->first()->value;

        if ($rightSymbol == "false")
            $ret = $currency . sprintf('%0.' . $symbolDigits . 'f', $price);
        else
            $ret = sprintf('%0.' . $symbolDigits . 'f', $price) . $currency;

        return $ret;
    }
    public static function rightSymbol(){
        return DB::table('settings')->where('param', '=', "rightSymbol")->get()->first()->value;
    }
    public static function currency(){
        return DB::table('settings')->where('param', '=', "default_currencies")->get()->first()->value;
    }
    public static function symbolDigits(){
        return DB::table('settings')->where('param', '=', "default_currencyCode")->
        join("currencies", 'currencies.code', '=', 'settings.value')->get()->first()->digits;
    }

}