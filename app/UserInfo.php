<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserInfo
{
    public static function getUserRole()
    {
        $user = Auth::user();
        if ($user == null)
            return -1;
	    $role = $user->role;
        $roles = DB::table('roles')->where('id', '=', $role)->get()->first();
        return $roles->role;
    }

    public static function getUserRoleId(){
        return Auth::user()->role;
    }

    public static function getUserAvatar()
    {
        $imageAvatar = "img/user.png";
        $user = Auth::user();
        if ($user == null)
            return "";
        $imageid = Auth::user()->imageid;
        if ($imageid != null) {
            $imageid = DB::table('image_uploads')->where('id', '=', $imageid)->get()->first();
            if ($imageid != null)
                $imageAvatar = 'images/' . $imageid->filename;
        }
        return $imageAvatar;
    }

    public static function getUserPermission($name)
    {
        return true;
    }

}
