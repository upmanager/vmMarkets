<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Theme
{
    public static function init(){
        if (Auth::user() == null)
            return;
        if (count(DB::table('settings')->where("param", 'ap_mainColor')->where("vendor", Auth::user()->id)->get()) == 0)
            DB::table('settings')->insert(['param' => 'ap_mainColor', 'value' => '1e1e2d', 'vendor' => Auth::user()->id, 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        if (count(DB::table('settings')->where("param", 'ap_secondColor')->where("vendor", Auth::user()->id)->get()) == 0)
            DB::table('settings')->insert(['param' => 'ap_secondColor', 'value' => '3699ff', 'vendor' => Auth::user()->id, 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        if (count(DB::table('settings')->where("param", 'ap_alertColor')->where("vendor", Auth::user()->id)->get()) == 0)
            DB::table('settings')->insert(['param' => 'ap_alertColor', 'value' => 'f64e60', 'vendor' => Auth::user()->id, 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        if (count(DB::table('settings')->where("param", 'ap_radius')->where("vendor", Auth::user()->id)->get()) == 0)
            DB::table('settings')->insert(['param' => 'ap_radius', 'value' => '6', 'vendor' => Auth::user()->id, 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);

    }

    public static function restore(){
        DB::table('settings')->where("param", 'ap_mainColor')->where("vendor", Auth::user()->id)->
            update(['param' => 'ap_mainColor', 'value' => '1e1e2d', 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where("param", 'ap_secondColor')->where("vendor", Auth::user()->id)->
            update(['param' => 'ap_secondColor', 'value' => '3699ff', 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where("param", 'ap_alertColor')->where("vendor", Auth::user()->id)->
            update(['param' => 'ap_alertColor', 'value' => 'f64e60', 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where("param", 'ap_radius')->where("vendor", Auth::user()->id)->
            update(['param' => 'ap_radius', 'value' => '6', 'updated_at' => new \DateTime(),]);

    }

    public static function getMainColor(){
        Theme::init();
        if (Auth::user() == null)
            return '1e1e2d';
        return DB::table('settings')->where("param", 'ap_mainColor')->where("vendor", Auth::user()->id)->get()->first()->value;
    }

    public static function getMenuTextColorInactive(){
        return "8da3b7";
    }
    public static function getMenuTextColorHover(){
        return "FFFFFF";
    }

    public static function getSecondColor(){
        Theme::init();
        if (Auth::user() == null)
            return '3699ff';
        return DB::table('settings')->where("param", 'ap_secondColor')->where("vendor", Auth::user()->id)->get()->first()->value;
    }

    // label 1
    public static function getLabelColor(){
        return "e1f0ff";
    }
    public static function getLabelBkgColor(){
        return "3699ff";
    }
    public static function getLabelColor2(){
        return "fff4de";
    }
    public static function getLabelBkgColor2(){
        return "ffa800";
    }

    //
    public static function getAlertColor(){
        Theme::init();
        if (Auth::user() == null)
            return 'f64e60';
        return DB::table('settings')->where("param", 'ap_alertColor')->where("vendor", Auth::user()->id)->get()->first()->value;
    }

    public static function getRadius(){
        Theme::init();
        if (Auth::user() == null)
            return '6';
        return DB::table('settings')->where("param", 'ap_radius')->where("vendor", Auth::user()->id)->get()->first()->value;
    }

    public static function getFontSize(){
        return "14px";
    }
}
