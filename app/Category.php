<?php

namespace App;

use App\Lang;
use Illuminate\Support\Facades\DB;
use Auth;

class Category
{
    public static function getCat($restaurantid)
    {
        $categories = [];
        $categoriesAll = DB::table('categories')->where("visible", "1")->get();
        foreach ($categoriesAll as &$value) {
            $t = DB::table('foods')->where('restaurant',"=", $restaurantid)->where('category',"=", $value->id)->get()->first();
            if ($t != null)
                $categories[] = Category::addImage($value);
        }
        foreach ($categories as &$value) {
            if ($value->parent != 0){
                $found = 0;
                foreach ($categories as &$value2){
                    if ($value2->id == $value->parent)
                        $found = 1;
                }
                if ($found == 0) {
                    $t = DB::table('categories')->where("id", $value->parent)->get()->first();
                    if ($t != null)
                        $categories[] = Category::addImage($t);
                }
            }
        }
        return $categories;
    }

    public static function addImage($value){
        $item = DB::table('image_uploads')->where('id',$value->imageid)->get()->first();
        if ($item != null)
            $value->image = $item->filename;
        else
            $value->image = "noimage.png";
        return $value;
    }
}
