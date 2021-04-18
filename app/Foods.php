<?php

namespace App;

use App\Lang;
use Illuminate\Support\Facades\DB;
use Auth;

class Foods
{
    public $url;

    public function fill($data)
    {
        // restaurants
        $restaurants = DB::table('restaurants')->get();

        $fav = [];
        foreach ($data as &$value) {
           $value2 = Foods::fill2($value, $restaurants);
            if ($value2 != null)
                $fav[] = $value2;
        }

        return $fav;
    }

    public function fill2($value2, $restaurants)
    {
        $value2->ver = '2';
        $t = DB::table('image_uploads')->where('id',$value2->imageid)->get()->first();
        if ($t != null)
            $value2->image = $t->filename;
        else
            $value2->image = "noimage.png";

        $restaurantYes = false;
        foreach ($restaurants as &$value4) {
            if ($value2->restaurant == $value4->id) {
                $value2->restaurantName = $value4->name;
                $value2->restaurantPhone = $value4->phone;
                $value2->restaurantMobilePhone = $value4->mobilephone;
                $value2->fee = $value4->fee;
                $value2->tax = $value4->tax;
                $value2->percent = $value4->percent;
                $restaurantYes = true;
            }
        }
        // reviews
        $value2->foodsreviews  = DB::table('foodsreviews')->where('food',$value2->id)->
                join("users", 'users.id', '=', 'foodsreviews.user')->
                leftjoin("image_uploads", 'image_uploads.id', '=', 'users.imageid')->
                select('foodsreviews.*', 'image_uploads.filename as image', 'users.name as userName')->get();
        foreach ($value2->foodsreviews as &$value7) {
            if ($value7->image == null || $value7->image == "")
                $value7->image = "noimage.png";
        }
        // variants
        $value2->variants = DB::select("SELECT variants.*, image_uploads.filename as image
                                        FROM variants
                                        LEFT JOIN image_uploads ON variants.imageid=image_uploads.id
                                        WHERE food=$value2->id ORDER BY variants.price ASC
                                        ");
        $value2->rproducts = DB::select("SELECT rproducts.rp FROM rproducts WHERE food=$value2->id");
        // images
        if ($value2->images != null){
            $images = explode(",", $value2->images);
            foreach ($images as &$data) {
                $filename = DB::table('image_uploads')->where("id", $data)->get()->first();
                if ($filename != null)
                    $filename = $filename->filename;
                else
                    $filename = "noimage.png";
                $value2->images_files[] = $filename;
            }
        }
        // save
        if ($value2->published == '1')
            if ($restaurantYes)
                return $value2;

        return null;
    }
}
