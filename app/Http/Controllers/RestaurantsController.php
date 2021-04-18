<?php

namespace App\Http\Controllers;

use App\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\UserInfo;

class RestaurantsController extends Controller
{
    public function load(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        $text = $request->input('text');
        if ($text != null)
            return RestaurantsController::view("green", $text);

        return RestaurantsController::view("", "");
    }

    public function view($green, $text){
        $petani = DB::table('image_uploads')->get();
        $restaurants = DB::table('restaurants')->leftjoin("image_uploads", 'image_uploads.id', '=', 'restaurants.imageid')->
                select('restaurants.*', 'image_uploads.filename as filename')->get();
        $currency = DB::table('settings')->where('param', '=', "default_currencies")->get()->first()->value;

        foreach ($restaurants as &$value7) {
            if ($value7->published == "1")
                $value7->published = "true";
            else
                $value7->published = "false";
            if ($value7->filename == "")
                $value7->filename = "noimage.png";
        }

        return view('restaurants', ['petani' => $petani, 'restaurants' => $restaurants, 'texton' => $green, 'text' => $text, 'currency' => $currency]);
    }

    //
    // Enable And Disable market
    //
    public function restaurantEnable(Request $request)
    {
        if (!Auth::check())
            return response()->json(['ret'=>'1']);
        if (Auth::user()->role != 1)
            return response()->json(['ret'=>'2']);

        $id = $request->input('id');
        $value = $request->input('value');
        DB::table('restaurants')->where('id',$id)->update(array('published' => $value));
        return response()->json(['ret'=>'0']);
    }

}
