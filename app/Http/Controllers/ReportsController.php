<?php

namespace App\Http\Controllers;

use App\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Currency;

// 31.01.2021

class ReportsController extends Controller
{
    public function mostpopular(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        if (Auth::user()->role == '2')
            $data = DB::table('favorites')->selectRaw('favorites.food, count(*) as result')->groupBy('favorites.food')->
                leftJoin("foods", "foods.id", "=", "favorites.food")->
                    where('foods.vendor', Auth::id())->orderBy('result', 'desc')->limit(30)->get();
        else // owner
            $data = DB::table('favorites')->selectRaw('favorites.food, count(*) as result')->groupBy('favorites.food')->
                leftJoin("foods", "foods.id", "=", "favorites.food")->
                orderBy('result', 'desc')->limit(30)->get();

        foreach ($data as &$value) {
            $food = DB::table('foods')->where('id', '=', $value->food)->get()->first();
            if ($food != null) {
                $t = DB::table('image_uploads')->where('id', '=', $food->imageid)->get()->first();
                if ($t != null)
                    $value->image = $t->filename;
                else
                    $value->image = "noimage.png";
                $value->name = $food->name;
                $t = DB::table('restaurants')->where('id', '=', $food->restaurant)->get()->first();
                if ($t != null)
                    $value->restaurantname = $t->name;
                else
                    $value->restaurantname = "Deleted";
            }else {
                $value->name = "Deleted";
                $value->image = "Unknown";
                $value->restaurantname = "Unknown";
            }
        }

        if (Auth::user()->role == '2')
            $data2 = DB::table('favorites')->leftJoin("foods", "foods.id", "=", "favorites.food")->
                    where('foods.vendor', Auth::id())->
                    orderBy('favorites.updated_at', 'desc')->
                    select('favorites.*')->
                    limit(30)->get();
        else
            $data2 = DB::table('favorites')->leftJoin("foods", "foods.id", "=", "favorites.food")->
                select('favorites.*')->
                orderBy('favorites.updated_at', 'desc')->limit(30)->get();

        foreach ($data2 as &$value) {
            $value->timeago = Util::timeago($value->updated_at);
            $food = DB::table('foods')->where('id', '=', $value->food)->get()->first();
            if ($food != null) {
                $t = DB::table('image_uploads')->where('id', '=', $food->imageid)->get()->first();
                if ($t != null)
                    $value->image = $t->filename;
                else
                    $value->image = "noimage.png";
                $value->name = $food->name;
                $t = DB::table('users')->where('id', '=', $value->user)->get()->first();
                if ($t != null)
                    $value->customername = $t->name;
                else
                    $value->customername = "Deleted";
                $t = DB::table('restaurants')->where('id', '=', $food->restaurant)->get()->first();
                if ($t != null)
                    $value->restaurantname = $t->name;
                else
                    $value->restaurantname = "Deleted";
            }else{
                $value->name = "Deleted";
                $value->image = "noimage.png";
                $value->customername = "Unknown";
                $value->restaurantname = "Unknown";
            }
        }

        return view('mostpopular', ['idata' => $data, 'data2' => $data2, 'role' => Auth::user()->role]);
    }

    public function mostpurchase(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        if (Auth::user()->role == '2')
            $data = DB::table('ordersdetails')->selectRaw('ordersdetails.foodid, count(*) as result')->groupBy('ordersdetails.foodid')->
                    leftJoin("foods", "foods.id", "=", "ordersdetails.foodid")->
                    where('foods.vendor', Auth::id())->
                    orderBy('result', 'desc')->limit(30)->get();
        else // owner
            $data = DB::table('ordersdetails')->selectRaw('ordersdetails.foodid, count(*) as result')->groupBy('ordersdetails.foodid')->
                leftJoin("foods", "foods.id", "=", "ordersdetails.foodid")->
                orderBy('result', 'desc')->limit(30)->get();

        foreach ($data as &$value) {
            $food = DB::table('foods')->where('id', '=', $value->foodid)->get()->first();
            if ($food != null) {
                $t = DB::table('image_uploads')->where('id', '=', $food->imageid)->get()->first();
                if ($t != null)
                    $value->image = $t->filename;
                else
                    $value->image = "noimage.png";
                $value->name = $food->name;
                $t = DB::table('restaurants')->where('id', '=', $food->restaurant)->get()->first();
                if ($t != null)
                    $value->restaurantname = $t->name;
                else
                    $value->restaurantname = "Deleted";
            }else {
                $value->name = "Deleted";
                $value->image = "noimage.png";
                $value->restaurantname = "Unknown";
            }
        }

        return view('mostpurchase', ['idata' => $data, 'role' => Auth::user()->role]);
    }

    public function toprestaurants(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        $data = DB::table('orders')->selectRaw('restaurant, count(*) as result, sum(orders.total) as total')->
                groupBy('restaurant')->orderBy('result', 'desc')->limit(30)->get();

        foreach ($data as &$value) {
            $value->total = Currency::makePrice($value->total);
            $restaurant = DB::table('restaurants')->where('id', '=', $value->restaurant)->get()->first();
            if ($restaurant != null) {
                $value->name = $restaurant->name;
                $t = DB::table('image_uploads')->where('id', '=', $restaurant->imageid)->get()->first();
                if ($t != null)
                    $value->image = $t->filename;
                else
                    $value->image = "noimage.png";
            }else{
                $value->name = "Deleted";
                $value->image = "noimage.png";
            }
        }

        return view('toprestaurants', ['idata' => $data]);
    }
}
