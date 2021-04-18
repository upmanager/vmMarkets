<?php
namespace App\Http\Controllers\API\owner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use App\UserInfo;
use App\Settings;

class FoodsController extends Controller
{
    public function load()
    {
        return FoodsController::foodsRet("");
    }

    public function foodsRet($id)
    {
        $foods = DB::table('foods')->where('vendor', Auth::user()->id)->get();
        $restaurants = DB::table('restaurants')->where('id', Auth::user()->vendor)->select('id', 'name', 'published')->get();

        $images = DB::table('image_uploads')->select('id', 'filename')->get();
        $temp = DB::table('settings')->where('param', '=', "default_currencyCode")->get()->first()->value;
        $symbolDigits = DB::table('currencies')->where('code', '=', $temp)->get()->first()->digits;
        $response = [
            'error' => '0',
            'id' => $id,
            'images' => $images,
            'foods' => $foods,
            'restaurants' => $restaurants,
            'extrasGroup' => null,
            'nutritionGroup' => null,
            'numberOfDigits' => $symbolDigits,
        ];
        return response()->json($response, 200);
    }

    public function foodSave(Request $request)
    {
        $edit = $request->input('edit') ?: "0";
        $editId = $request->input('editId') ?: "0";

        $values = array(
            'name' => $request->input('name'),
            'imageid' => $request->input('imageid') ?: 0,
            'images' => $request->input('moreimages') ?: 0,
            'price' => $request->input('price'),
            'discountprice' => $request->input('discountPrice'),
            'desc' => $request->input('desc') ?: "",
            'restaurant' => $request->input('restaurant') ?: 0,
            'category' => $request->input('category') ?: 0,
            'ingredients' => $request->input('ingredients') ?: "",
            'unit' => "",
            'packageCount' => 0,
            'weight' => 0,
            'canDelivery' => 1,
            'published' => $request->input('published'),
            'stars' => 5,
            'extras' => $request->input('extras') ?: 0,
            'nutritions' => $request->input('nutritions') ?: 0,
            'vendor' => Auth::user()->id,
            'updated_at' => new \DateTime());

        $id = $editId;
        if ($edit == '1')
            DB::table('foods')->where('id',$editId)->where('vendor', Auth::user()->id)->update($values);
        else{
            $values['created_at'] = new \DateTime();
            DB::table('foods')->insert($values);
            $id = DB::getPdo()->lastInsertId();
        }

        return FoodsController::foodsRet($id);
    }

    public function foodDelete(Request $request)
    {
        $id = $request->input('id');
        DB::table('foods')->where('id',$id)->where('vendor', Auth::user()->id)->delete();
        return FoodsController::foodsRet("");
    }


}
