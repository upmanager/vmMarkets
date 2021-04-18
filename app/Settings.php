<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Settings
{
    public static function getVersion()
    {
        return DB::table('settings')->where('param', '=', "version")->get()->first()->value;
    }

    public static function isDemoMode()
    {
        $settings = DB::table('settings')->where('param', '=', "demo_mode")->get()->first();
        if ($settings->value == 'true')
            return true;
        return false;
    }

    public static function getCopyright()
    {
        return DB::table('docs')->where('param', '=', "copyright_text")->get()->first()->value;;
    }
}
