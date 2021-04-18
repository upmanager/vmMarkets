<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Currency;

// 31.01.2021

class DriversController extends Controller
{
    public function load(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        $users = DB::table('users')->where("role", "3")->get();
        foreach ($users as &$value) {
            $totals = DB::table('orders')->where("driver", "$value->id")->where("status", "5")->get();
            $count = 0;
            $summa = 0;
            foreach ($totals as &$value2) {
                $count++;
                if ($value2->percent == '1')
                    $summa = $summa + ($value2->total*$value2->fee/100);
                else
                    $summa = $summa + $value2->fee;
            }
            $value->total = sprintf('%0.2f', $summa); // 520 -> 520.00;
            $value->count = $count;
        }
        $currencies = DB::table('settings')->where('param', '=', "default_currencies")->get()->first()->value;
        return view('drivers', ['iusers' => $users, 'currencies' => $currencies]);
    }

    public function goPage(Request $request)
    {
        if (!Auth::check())
            return response()->json(['error'=>"1"]);

        $search = $request->input('search', "") ? : "";
        $page = $request->input('page', "1") ? : 1;
        $count = $request->input('count', 10) ? : 10;
        $sortBy = $request->input('sortBy', "id") ? : "id";
        $sortAscDesc = $request->input('sortAscDesc', "asc") ? : "asc";
        $sortOnline = $request->input('sortOnline', "1");
        $sortOffline = $request->input('sortOffline', "1");

        $offset = ($page - 1) * $count;

        $searchVisible = "";
        if ($sortOnline != '1' || $sortOffline != '1') {
            if ($sortOnline == '1')
                $searchVisible = "AND users.active = '1' ";
            if ($sortOffline == '1')
                $searchVisible = " AND (users.active='0' OR users.active is null) ";
        }
        if ($sortOnline == '0' && $sortOffline == '0')
            $searchVisible = " AND users.active='3' ";

        $str = "SELECT users.id, users.name, users.active,
                    count(orders.id) as count,
                    IFNULL(sum(orders.total), 0) as total
                    FROM users LEFT JOIN orders ON orders.driver=users.id AND orders.status=5
                    WHERE users.role='3' "
            . $searchVisible .
            " AND users.name LIKE '%" . $search . "%'
                    GROUP BY users.id, users.name, users.active
                    ORDER BY " . $sortBy . " " . $sortAscDesc .
            " LIMIT " . $count .
            " OFFSET " . $offset;
        $data = DB::select($str);

        $total = count(DB::select("SELECT * FROM users WHERE role='3' " . $searchVisible . " AND name LIKE '%" . $search . "%'"));

        $t = $total/$count;
        if ($total%$count > 0)
            $t++;

        foreach ($data as &$user)
            $user->total = Currency::makePrice($user->total);

        return response()->json(['data' => $data, 'error'=>"0", 'idata' => $data, 'page' => $page, 'pages' => $t]);
    }

}
