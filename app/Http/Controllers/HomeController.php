<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Logging;
use App\UserInfo;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     */
    public function index()
    {
        if (!Auth::check())
            return \Redirect::route('/');

        $usersCount = count(DB::table('users')->get());
        if (Auth()->user()->role == 1)
            $orders = DB::table('orders')->get();
        else
            $orders = DB::table('orders')->where('vendor', Auth::id())->get();
        $ordersCount = count($orders);
        $restaurantsCount = count(DB::table('restaurants')->get());

        $nowYear = Carbon::now()->year;

        $all = 0;

        $e1 = 0;
        $e2 = 0;
        $e3 = 0;
        $e4 = 0;
        $e5 = 0;
        $e6 = 0;
        $e7 = 0;
        $e8 = 0;
        $e9 = 0;
        $e10 = 0;
        $e11 = 0;
        $e12 = 0;

        foreach ($orders as &$value) {
            $all += $value->total;
            if ($nowYear == Carbon::createFromFormat('Y-m-d H:i:s', $value->updated_at)->year){
                $month = Carbon::createFromFormat('Y-m-d H:i:s', $value->updated_at)->month;
                if ($month == 1)
                    $e1 += $value->total;
                if ($month == 2)
                    $e2 += $value->total;
                if ($month == 3)
                    $e3 += $value->total;
                if ($month == 4)
                    $e4 += $value->total;
                if ($month == 5)
                    $e5 += $value->total;
                if ($month == 6)
                    $e6 += $value->total;
                if ($month == 7)
                    $e7 += $value->total;
                if ($month == 8)
                    $e8 += $value->total;
                if ($month == 9)
                    $e9 += $value->total;
                if ($month == 10)
                    $e10 += $value->total;
                if ($month == 11)
                    $e11 += $value->total;
                if ($month == 12)
                    $e12 += $value->total;
            }

        }

        $settings = DB::table('settings')->where('param', '=', "default_currencies")->get();
        $orderstatus = DB::table('orderstatuses')->get();
        if (Auth()->user()->role == 1)
            $orders = DB::table('orders')->
                leftJoin("users", "users.id", "=", "orders.user")->
            leftJoin("restaurants", "restaurants.id", "=", "orders.restaurant")->
                select("orders.*", "users.name", "restaurants.name as restaurantName")->orderBy('updated_at', 'desc')->limit(10)->get();
        else
            $orders = DB::table('orders')->
                leftJoin("users", "users.id", "=", "orders.user")->
                select("orders.*", "users.name")->
                where('orders.vendor', Auth::id())->orderBy('updated_at', 'desc')->limit(10)->get();
        $iusers = DB::table('users')->get();

        return view('home', ['userscount' => $usersCount, 'orderscount' => $ordersCount,
            'restaurantsCount' => $restaurantsCount, 'earning' => $all, 'currency' => $settings[0]->value,
            'iorderstatus' => $orderstatus, 'iorders' => $orders, 'iusers' => $iusers,
            'e1' => $e1, 'e2' => $e2, 'e3' => $e3, 'e4' => $e4, 'e5' => $e5, 'e6' => $e6,
            'e7' => $e7, 'e8' => $e8, 'e9' => $e9, 'e10' => $e10, 'e11' => $e11, 'e12' => $e12,
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome()
    {
        return view('adminHome');
    }

}
