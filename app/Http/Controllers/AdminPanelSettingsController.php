<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Theme;

// 12.02.2021

class AdminPanelSettingsController extends Controller
{
    public function load(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        Theme::init();

        $vendor = 0;
        if (Auth::user()->role > 1)
            $vendor = Auth::user()->id;
        $defLang = DB::table('settings')->where('param',"panelLang")->where("vendor", $vendor)->get()->first()->value;

        return view('apSettings', [
            'ap_mainColor' => DB::table('settings')->where("param", 'ap_mainColor')->where("vendor", Auth::user()->id)->get()->first()->value,
            'ap_secondColor' => DB::table('settings')->where("param", 'ap_secondColor')->where("vendor", Auth::user()->id)->get()->first()->value,
            'ap_alertColor' => DB::table('settings')->where("param", 'ap_alertColor')->where("vendor", Auth::user()->id)->get()->first()->value,
            'ap_radius' => DB::table('settings')->where("param", 'ap_radius')->where("vendor", Auth::user()->id)->get()->first()->value,
            // default lang
            'langs' => Config::get("langs"),
            'defLang' => $defLang,
        ]);
    }

    public function apSaveSettings(Request $request)
    {
        if (!Auth::check())
            return response()->json(['error' => "1"], 200);

        DB::table('settings')->where("param", 'ap_mainColor')->where("vendor", Auth::user()->id)->
            update(['param' => 'ap_mainColor', 'value' => $request->input('ap_mainColor'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where("param", 'ap_secondColor')->where("vendor", Auth::user()->id)->
            update(['param' => 'ap_secondColor', 'value' => $request->input('ap_secondColor'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where("param", 'ap_alertColor')->where("vendor", Auth::user()->id)->
            update(['param' => 'ap_alertColor', 'value' => $request->input('ap_alertColor'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where("param", 'ap_radius')->where("vendor", Auth::user()->id)->
            update(['param' => 'ap_radius', 'value' => $request->input('ap_radius'), 'updated_at' => new \DateTime(),]);


        return response()->json(['error' => "0"], 200);
    }

    public function apRestoreSettings(Request $request)
    {
        if (!Auth::check())
            return response()->json(['error' => "1"], 200);

        Theme::restore();

        return response()->json(['error' => "0"], 200);
    }



}
