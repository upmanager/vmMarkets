<?php

namespace App\Http\Controllers;

use App\Lang;
use App\Settings;
use App\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class FaqController extends Controller
{
    public function load(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');
        return view('faq', []);
    }

    public function add(Request $request)
    {
        if (!Auth::check())
            return response()->json(['error' => "1"]);

        $id = $request->input('id', "0"); // for edit
        $values = array(
            'question' => $request->input('question'),
            'answer' => $request->input('answer'),
            'published' => $request->input('published'),
            'updated_at' => new \DateTime());

        if ($id != "0"){
            DB::table('faq')->where('id', $id)->update($values);
        }else{
            $values['created_at'] = new \DateTime();
            DB::table('faq')->insert($values);
            $id = DB::getPdo()->lastInsertId();
        }
        return FaqController::getOne($id);
    }

    public function GetInfo(Request $request)
    {
        if (!Auth::check())
            return response()->json(['error' => "1"]);

        $id = $request->input('id', "0");
        if ($id == "0")
            return response()->json(['error' => "4"]);

        return FaqController::getOne($id);
    }

    public function getOne($id){
        $faq = DB::table('faq')->where("id", $id)->get()->first();
        $faq->timeago = Util::timeago($faq->updated_at);
        return response()->json(['error'=>"0", 'data' => $faq]);
    }

    public function delete(Request $request){
        if (!Auth::check())
            return response()->json(['error' => "1"]);
        if (Settings::isDemoMode())
            return response()->json(['error'=>'2', 'text' => Lang::get(489)]); // This is demo app. You can't change this section
        $id = $request->input('id');
        DB::table('faq')->where('id',$id)->delete();
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
        $sortPublished = $request->input('sortPublished', "1");
        $sortUnPublished = $request->input('sortUnPublished', "1");

        $offset = ($page - 1) * $count;

        $searchVisible = "";
        if ($sortPublished != '1' || $sortUnPublished != '1') {
            if ($sortPublished == '1')
                $searchVisible = "published = '1' AND ";
            if ($sortUnPublished == '1')
                $searchVisible = "published = '0' AND ";
        }
        if ($sortPublished == '0' && $sortUnPublished == '0')
            $searchVisible = "visible='3' AND ";

        $datas = DB::select("SELECT * FROM faq WHERE $searchVisible question LIKE '%$search%' ORDER BY $sortBy  $sortAscDesc LIMIT $count OFFSET $offset");
        $total = count(DB::select("SELECT * FROM faq WHERE $searchVisible question LIKE '%$search%' " ));

        foreach ($datas as &$data)
            $data->timeago = Util::timeago($data->updated_at);

        $t = $total/$count;
        if ($total%$count > 0)
            $t++;

        return response()->json(['error'=>"0", 'idata' => $datas, 'page' => $page, 'pages' => $t, 'total' => $total]);
    }

}
