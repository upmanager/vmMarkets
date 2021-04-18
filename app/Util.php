<?php

namespace App;

use App\Lang;
use Illuminate\Support\Facades\DB;
use Auth;

class Util
{
    public static function timeago($date)
    {
        $timestamp = strtotime($date);

        $strTime = array("second", "minute", "hour", "day", "month", "year");
        $length = array("60", "60", "24", "30", "12", "10");

        $currentTime = time();
        if ($currentTime >= $timestamp) {
            $diff = time() - $timestamp;
            for ($i = 0; $diff >= $length[$i] && $i < count($length) - 1; $i++) {
                $diff = $diff / $length[$i];
            }

            $diff = round($diff);
            return $diff . " " . $strTime[$i] . "(s) ago ";
        }
    }

    public static function getCategories()
    {
        $vendor = Auth::id();
        if (Auth::user()->role == 1)
            $vendor = 0;

        $cat = DB::table('categories')->
            leftjoin("image_uploads", 'image_uploads.id', '=', 'categories.imageid')->
            select('categories.*', 'image_uploads.filename as image')->
            where('categories.vendor', $vendor)->where('categories.visible', '1')->get();
        foreach ($cat as &$food) {
            if ($food->image == null)
                $food->image = "noimage.png";
        }
        $catOwner = null;
        if (Auth::user()->role == 2){
            $catOwner = DB::table('categories')->
            leftjoin("image_uploads", 'image_uploads.id', '=', 'categories.imageid')->
            select('categories.*', 'image_uploads.filename as image')->
            where('categories.vendor', '0')->where('categories.visible', '1')->get();
            foreach ($catOwner as &$food) {
                if ($food->image == null)
                    $food->image = "noimage.png";
                $food->name = $food->name . " || " . Lang::get(576);
                $cat[] = $food;
            }
        }
        $ret = array();
//        if ($catOwner != null)
//            $ret = Util::getSubElements($catOwner, 0, 0, $ret);
        $ret = Util::getSubElements($cat, 0, 0, $ret);

        return $ret;
    }

    public static function getSubElements($cat, $parent, $level, $ret){
        foreach ($cat as &$data) {
            if ($data->parent == $parent){
                if ($level == 1) $data->name = '&nbsp;&nbsp;&nbsp;&nbsp;' . $data->name;
                if ($level == 2) $data->name = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $data->name;
                if ($level == 3) $data->name = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $data->name;
                if ($level == 4) $data->name = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $data->name;
                if ($level == 5) $data->name = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $data->name;
                //$ret[] = (object) array('id'=> 1, 'name' => $level);
                $ret[] = $data;
                $ret = Util::getSubElements($cat, $data->id, $level+1, $ret);
            }
        }
        return $ret;
    }

    public static function getRestaurants()
    {
        return DB::table('restaurants')->get();
    }

    public static function getNutritions()
    {
        return DB::table('nutritiongroup')->get();
    }

    public static function getExtras()
    {
        return DB::table('extrasgroup')->get();
    }

    public static function getRoles()
    {
        if (UserInfo::getUserRoleId() == '1')
            return DB::table('roles')->get();
        else
            return DB::table('roles')->where("id", ">", "2")->get();
    }

    public static function getImages()
    {
        if (UserInfo::getUserRoleId() == '1')
            $ret = DB::table('image_uploads')->get();
        else
            $ret = DB::table('image_uploads')->where('vendor', Auth::id())->get();
        foreach ($ret as &$data) {
            $data->title = substr($data->filename, 13);
        }

        return $ret;
    }

    public static function getOrdersStatus()
    {
        return DB::table('orderstatuses')->get();
    }

    public static function getDoc($param)
    {
        return DB::table('docs')->where("param", $param)->get()->first()->value;
    }

    public static function getUsers(){
        return DB::table('users')->get();
    }

    public static function getFoods()
    {
        if (Auth::user()->role == 1)
            $foods = DB::table('foods')->
                leftjoin("image_uploads", 'image_uploads.id', '=', 'foods.imageid')->
                select('foods.*', 'image_uploads.filename as filename')->get();
        else
            $foods = DB::table('foods')->
                leftjoin("image_uploads", 'image_uploads.id', '=', 'foods.imageid')->
                where('foods.vendor', Auth::id())->
                select('foods.*', 'image_uploads.filename as filename')->get();
        foreach ($foods as &$food) {
            if ($food->filename == null)
                $food->filename = "noimage.png";
        }
        return $foods;
    }

}
