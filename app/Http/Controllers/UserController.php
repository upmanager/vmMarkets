<?php

namespace App\Http\Controllers;

use App\Settings;
use App\Lang;
use App\Util;
use App\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

// 31.01.2021

class UserController extends Controller
{
    public function users(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        $user_id = $request->input('user_id') ?: "";
        $restaurants = DB::table('restaurants')->get();
        return view('users', ['showuser' => $user_id,
            'restaurants' => $restaurants,
        ]);
    }

    public function usersGoPage(Request $request)
    {
        if (!Auth::check())
            return response()->json(['error'=>"1"]);

        $search = $request->input('search') ? : "";
        $page = $request->input('page') ? : 1;
        $count = $request->input('count') ? : 10;
        $sortBy = $request->input('sortBy') ? : "id";
        $sortAscDesc = $request->input('sortAscDesc') ? : "asc";

        $offset = ($page - 1) * $count;

        $data = DB::select("SELECT * FROM users WHERE role=4 AND (email LIKE '%" . $search . "%' OR name LIKE '%" . $search . "%') ORDER BY " . $sortBy . " " . $sortAscDesc . " LIMIT " . $count . " OFFSET " . $offset);
        $total = count(DB::select("SELECT * FROM users WHERE role=4 AND (email LIKE '%" . $search . "%' OR name LIKE '%" . $search . "%')"));

        $t = $total/$count;
        if ($total%$count > 0)
            $t++;

        $roles = DB::table('roles')->get();
        foreach ($data as &$user) {
            $user->roleName = "user";
            $filename = DB::table('image_uploads')->where("id", $user->imageid)->get()->first();
            if ($filename != null)
                $user->filename = $filename->filename;
            else
                $user->filename = "noimage.png";
            foreach ($roles as &$role) {
                if ($user->role == $role->id) {
                    $user->roleName = $role->role;
                    break;
                }
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

        // create item id "users" table
        $email = $request->input('email') ?: "";
        if (DB::table('users')->where("email", $email)->get()->first() != null && $id == "0")
            return response()->json(['error'=>"2"]);

        $name = $request->input('name') ?: "";
//        $role = $request->input('role') ?: "";
//        $role = UserInfo::getUserRoleId();
        $email = $request->input('email') ?: "";
        $password = $request->input('password') ?: "";
        $phone = $request->input('phone') ?: "";
        $address = $request->input('address') ?: "";
        $image = $request->input('image') ?: 0;

        $values = array('name' => $name, 'email' => $email,
//            'role'=>$role,
            'imageid' => $image, 'address' => $address, 'phone' => $phone,
            'updated_at' => new \DateTime());

        if ($id != "0"){
            if ($password != "")
                $values['password'] = bcrypt($password);
            DB::table('users')->where('id', $id)->update($values);
        }else{
            $values['password'] = bcrypt($password);
            $values['created_at'] = new \DateTime();
            DB::table('users')->insert($values);
            $id = DB::getPdo()->lastInsertId();
        }

        return UserController::getOneUser($id);
    }

    public function getOneUser($id){
        $user = DB::table('users')->where("id", $id)->get()->first();
        $roles = DB::table('roles')->get();

        $user->roleName = "client";
        $filename = DB::table('image_uploads')->where("id", $user->imageid)->get()->first();
        if ($filename != null)
            $user->filename = $filename->filename;
        else
            $user->filename = "noimage.png";
        foreach ($roles as &$role) {
            if ($user->role == $role->id) {
                $user->roleName = $role->role;
                break;
            }
        }
        $user->timeago = Util::timeago($user->updated_at);
        return response()->json(['error'=>"0", 'user' => $user]);
    }

    public function userGetInfo(Request $request)
    {
        if (!Auth::check())
            return response()->json(['error' => "1"]);

        $id = $request->input('id', "0");
        if ($id == 0)
            return response()->json(['error' => "4"]);

        return UserController::getOneUser($id);
    }

    public function delete(Request $request){
        if (!Auth::check())
            return response()->json(['error' => "1"]);
        if (Settings::isDemoMode())
            return response()->json(['error'=>'2', 'text' => Lang::get(489)]); // This is demo app. You can't change this section
        $id = $request->input('id');
        DB::table('users')->where('id',$id)->delete();
        return response()->json(['error'=>'0']);
    }
}
