<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\DB;
use App\Foods;

class CategoryController extends Controller
{
    public function get(Request $request)
    {
        $petani = DB::table('image_uploads')->get();
        $restaurants = DB::table('restaurants')->get();
        $fav = [];
        $category = $request->input('category');

        $fcl = new Foods();

        $foods = DB::table('foods')->where('category', '=', $category)->get();
        if (count($foods) == 0){
            $cats = DB::table('categories')->where("parent", $category)->get();
            foreach ($cats as &$value3) {
                $data = DB::table('foods')->where('category', $value3->id)->orderBy('foods.updated_at', 'desc')->limit(10)->get();
                if ($data != null){
                    foreach ($data as &$value2) {
                        $value2 = $fcl->fill2($value2, $restaurants);
                        if (!in_array($value2, $fav)) {
                            $fav[] = $value2;
                        }
                    }
                }
            }
        }else{
            foreach ($foods as &$value2) {
                $value2 = $fcl->fill2($value2, $restaurants);
                if ($value2 != null)
                    $fav[] = $value2;
            }
        }

        $currencies = DB::table('settings')->where('param', '=', "default_currencies")->get()->first()->value;
        $tax = DB::table('settings')->where('param', '=', "default_tax")->get()->first()->value;
        $categories = DB::table('categories')->where('id', '=', $category)->get()->first();

        $catimage = "noimage.png";
        foreach ($petani as &$value3) {
            if ($categories->imageid == $value3->id)
                $catimage = $value3->filename;
        }

        $response = [
            'error' => '0',
            'desc' => $categories->desc,
            'name' => $categories->name,
            'image' => $catimage,
            'foods' => $fav,
            'default_tax' => $tax,
            'currency' => $currencies,
        ];
        return response()->json($response, 200);
    }

}
