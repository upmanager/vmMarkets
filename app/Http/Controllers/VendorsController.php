<?php

namespace App\Http\Controllers;

use App\Settings;
use App\Lang;
use App\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

// 31.01.2021

class VendorsController extends Controller
{
    public function vendors(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        $user_id = $request->input('user_id') ?: "";
        $restaurants = DB::table('restaurants')->get();
        $sellersregs = DB::table('sellersregs')->get();
        foreach ($sellersregs as &$data)
            $data->timeago = Util::timeago($data->updated_at);
        return view('vendors', ['showuser' => $user_id,
            'restaurants' => $restaurants,
            'sellersregs' => $sellersregs
        ]);
    }

    public function vendorsGoPage(Request $request)
    {
        if (!Auth::check())
            return response()->json(['error'=>"1"]);

        $search = $request->input('search') ? : "";
        $page = $request->input('page') ? : 1;
        $count = $request->input('count') ? : 10;
        $sortBy = $request->input('sortBy') ? : "id";
        $sortAscDesc = $request->input('sortAscDesc') ? : "asc";

        $offset = ($page - 1) * $count;

        $data = DB::select("SELECT * FROM users WHERE role=2 AND (email LIKE '%" . $search . "%' OR name LIKE '%" . $search . "%') ORDER BY " . $sortBy . " " . $sortAscDesc . " LIMIT " . $count . " OFFSET " . $offset);
        $total = count(DB::select("SELECT * FROM users WHERE role=2 AND (email LIKE '%" . $search . "%' OR name LIKE '%" . $search . "%')"));

        $t = $total/$count;
        if ($total%$count > 0)
            $t++;

        foreach ($data as &$user) {
            $user->filename = DB::table("image_uploads")->where("id", $user->imageid)->get()->first();
            if ($user->filename != null)
                $user->filename = $user->filename->filename;
            else
                $user->filename = "noimage.png";

//            $filename = DB::select("SELECT image_uploads.filename FROM restaurants
//                    LEFT JOIN image_uploads ON image_uploads.id=restaurants.imageid WHERE restaurants.id=$user->vendor");
//            if (sizeof($filename) != 0)
//                $user->filename = $filename[0]->filename;

            $t = DB::table('restaurants')->where('id', $user->vendor)->get()->first();
            if ($t != null) {
                $user->commission = $t->commission;
                $user->shopName = $t->name;
            }

            $user->timeago = Util::timeago($user->updated_at);
        }

        return response()->json(['error'=>"0", 'idata' => $data, 'page' => $page, 'pages' => $t]);
    }

    public function add(Request $request)
    {
        if (!Auth::check())
            return response()->json(['error'=>"1"]);

        $id = $request->input('id', "0"); // for edit

        $email = $request->input('email') ?: "";
        if (DB::table('users')->where("email", $email)->get()->first() != null && $id == "0")
            return response()->json(['error'=>"2"]);

        $name = $request->input('name') ?: "";
        $password = $request->input('password') ?: "";

        $values = array(
            'name' => $name, 'email' => $email, 'role'=>2,
            'imageid' => 0, 'address' => '', 'phone' => '',
            'updated_at' => new \DateTime());

        if ($id != "0"){
            if ($password != "")
                $values['password'] = bcrypt($password);
            DB::table('users')->where('id', $id)->update($values);
            //
            $vendor = DB::table('users')->where('id', $id)->get()->first();
            if ($vendor != null) {
                $values = array(
                    'commission' => $request->input('commission'),
                    'updated_at' => new \DateTime());
                DB::table('restaurants')->where('id', $vendor->vendor)->update($values);
            }
        }else{
            $values2 = array(
                'name' => $name, 'imageid' => 0, 'desc' => "", 'published' => 1,
                'phone' => '', 'mobilephone' => '', 'address' => '', 'lat' => 0, 'lng' => 0,
                'fee' => 0, 'percent' => 1, 'perkm' => 0,
                'area' => 30, 'minAmount' => 0,
                'commission' => $request->input('commission'),
                'delivered' => 1, 'updated_at' => new \DateTime(), 'created_at' => new \DateTime(),
            );
            DB::table('restaurants')->insert($values2);
            $rid = DB::getPdo()->lastInsertId();
            $values['vendor'] = $rid;
            $values['password'] = bcrypt($password);
            $values['created_at'] = new \DateTime();
            DB::table('users')->insert($values);
            $id = DB::getPdo()->lastInsertId();
        }

        return VendorsController::getOneUser($id);
    }

    public function getOneUser($id){
        $user = DB::table('users')->where("id", $id)->get()->first();
        $user->timeago = Util::timeago($user->updated_at);
        $user->tax = DB::table('restaurants')->where("id", $user->vendor)->get()->first()->tax;
        $user->commission = DB::table('restaurants')->where("id", $user->vendor)->get()->first()->commission;
        return response()->json(['error'=>"0", 'user' => $user]);
    }

    public function getInfo(Request $request)
    {
        if (!Auth::check())
            return response()->json(['error' => "1"]);

        $id = $request->input('id', "0");
        if ($id == 0)
            return response()->json(['error' => "4"]);

        return VendorsController::getOneUser($id);
    }

    public function delete(Request $request){
        if (!Auth::check())
            return response()->json(['error' => "1"]);
        if (Settings::isDemoMode())
            return response()->json(['error'=>'2', 'text' => Lang::get(489)]); // This is demo app. You can't change this section
        $id = $request->input('id');
        $idrest = DB::table('users')->where('id', $id)->get()->first();
        if ($idrest != null)
            DB::table('restaurants')->where('id', $idrest->vendor)->delete();
        DB::table('users')->where('id',$id)->delete();
        return response()->json(['error'=>'0']);
    }

    public function sellerRegDelete(Request $request){
        if (!Auth::check())
            return response()->json(['error' => "1"]);
        if (Settings::isDemoMode())
            return response()->json(['error'=>'2', 'text' => Lang::get(489)]); // This is demo app. You can't change this section
        $id = $request->input('id');
        DB::table('sellersregs')->where('id', $id)->delete();
        return response()->json(['error'=>'0']);
    }


}
