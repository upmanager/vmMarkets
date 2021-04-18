<?php

namespace App\Http\Controllers;

use App\Settings;
use App\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Lang;

class FoodReviewsController extends Controller
{
    public function load(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        return view('foodreviews', []);
    }

    public function delete(Request $request){
        if (!Auth::check())
            return response()->json(['error' => "1"]);
        if (Settings::isDemoMode())
            return response()->json(['error'=>'2', 'text' => Lang::get(489)]); // This is demo app. You can't change this section
        $id = $request->input('id');
        DB::table('foodsreviews')->where('id',$id)->delete();
        return response()->json(['error'=>'0']);
    }

    public function GoPage(Request $request)
    {
        if (!Auth::check())
            return response()->json(['error'=>"1"]);

        $search = $request->input('search') ? : "";
        $page = $request->input('page') ? : 1;
        $count = $request->input('count', 10);
        $sortBy = $request->input('sortBy') ? : "id";
        $sortAscDesc = $request->input('sortAscDesc') ? : "asc";

        $offset = ($page - 1) * $count;

        $datas = DB::select("SELECT * FROM foodsreviews WHERE 'desc' LIKE '%$search%' ORDER BY $sortBy  $sortAscDesc LIMIT $count OFFSET $offset");
        $total = count(DB::select("SELECT * FROM foodsreviews WHERE 'desc' LIKE '%$search%' " ));

        foreach ($datas as &$data) {
            $data->timeago = Util::timeago($data->updated_at);
            //
            $user = DB::table('users')->where('id', $data->user)->get()->first();
            if ($user != null)
                $data->userName = $user->name;
            else
                $data->userName = Lang::get(577); // Deleted
            //
            $food = DB::table('foods')->where('id', $data->food)->get()->first();
            if ($food != null)
                $data->productName = $food->name;
            else
                $food->productName = Lang::get(577); // Deleted
        }

        $t = $total/$count;
        if ($total%$count > 0)
            $t++;

        return response()->json(['error'=>"0", 'idata' => $datas, 'page' => $page, 'pages' => $t, 'total' => $total]);
    }
}
