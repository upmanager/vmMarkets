<?php

namespace App\Http\Controllers;

use App\Lang;
use App\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class TransactionsController extends Controller
{
    public function load(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        return view('transactions', []);
    }


    public function goPage(Request $request)
    {
        if (!Auth::check())
            return response()->json(['error'=>"1"]);

        $page = $request->input('page') ? : 1;
        $count = $request->input('count', 10);
        $sortBy = $request->input('sortBy') ? : "id";
        $sortAscDesc = $request->input('sortAscDesc') ? : "asc";
        $offset = ($page - 1) * $count;

        $vend = "";
        if (Auth::user()->role == 2) {
            $vendorId = Auth::user()->id;
            $vend = "AND vendor=$vendorId";
        }

        $datas = DB::select("SELECT * FROM orders WHERE send='1' $vend ORDER BY $sortBy  $sortAscDesc LIMIT $count OFFSET $offset");
        $total = count(DB::select("SELECT * FROM orders WHERE send='1' $vend" ));

        foreach ($datas as &$data) {
            $data->timeago = Util::timeago($data->updated_at);
            if (Auth::user()->role == 1){
                $data->commission = 0;
                $data->shopName = "";
                $tm = DB::table("restaurants")->where('id', $data->restaurant)->get()->first();
                if ($tm != null) {
                    $data->commission = $tm->commission;
                    $data->shopName = $tm->name;
                }
            }
        }

        $t = $total/$count;
        if ($total%$count > 0)
            $t++;

        $commission = 0;
        $tm = DB::table("restaurants")->where('id', Auth::user()->vendor)->get()->first();
        if ($tm != null)
            $commission = $tm->commission;

        return response()->json(['error'=>"0", 'idata' => $datas, 'page' => $page, 'pages' => $t,
            'total' => $total, 'commission' => $commission]);
    }

}
