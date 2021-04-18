<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class Lang
{
    public static function init(){
        $vendor = 0;
        if (Auth::user() != null)
            if (Auth::user()->role > 1)
                $vendor = Auth::user()->id;
        if (count(DB::table('settings')->where("param", 'panelLang')->where("vendor", $vendor)->get()) == 0)
            DB::table('settings')->insert(['param' => 'panelLang', 'value' => 'langEng',
                "vendor" => $vendor, 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
    }

    public static function get($id)
    {
        Lang::init();
        $vendor = 0;
        if (Auth::user() != null)
            if (Auth::user()->role > 1)
                $vendor = Auth::user()->id;

        $lang = DB::table('settings')->where('param', "panelLang")->where("vendor", $vendor)->get()->first()->value;
        $t = Config::get("$lang.$id");
        return ($t == null ? Config::get("langEng.$id") : $t);
    }

    public static function setNewLang($newLang)
    {
        $vendor = 0;
        if (Auth::user() != null)
            if (Auth::user()->role > 1)
                $vendor = Auth::user()->id;

        DB::table('settings')->where('param', "panelLang")->where("vendor", $vendor)->
                                                    update(['value' => $newLang, 'updated_at' => new \DateTime(),]);
        //
        if ($vendor == 0) {
            DB::table('orderstatuses')->where('id', '=', "1")->update(['status' => Lang::get(438), 'updated_at' => new \DateTime(),]);
            DB::table('orderstatuses')->where('id', '=', "2")->update(['status' => Lang::get(439), 'updated_at' => new \DateTime(),]);
            DB::table('orderstatuses')->where('id', '=', "3")->update(['status' => Lang::get(440), 'updated_at' => new \DateTime(),]);
            DB::table('orderstatuses')->where('id', '=', "4")->update(['status' => Lang::get(441), 'updated_at' => new \DateTime(),]);
            DB::table('orderstatuses')->where('id', '=', "5")->update(['status' => Lang::get(442), 'updated_at' => new \DateTime(),]);
            DB::table('orderstatuses')->where('id', '=', "6")->update(['status' => Lang::get(443), 'updated_at' => new \DateTime(),]);
        }
    }

    public static function direction()
    {
        Lang::init();
        $lang = DB::table('settings')->where('param', '=', "panelLang")->get()->first()->value;
        $langs = Config::get("langs");
        foreach ($langs as &$value) {
            if ($value['file'] == $lang)
                return $value['dir'];
        }
        return "ltr";
    }
}
