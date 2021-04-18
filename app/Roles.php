<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\UserInfo;

class Roles
{
    public static function getRoles()
    {
        if (UserInfo::getUserRoleId() == '1')
            return DB::table('roles')->get();
        else
            return DB::table('roles')->where("id", ">", "2")->get();
    }
    public static function getRoles(){
        
    }
    
}
