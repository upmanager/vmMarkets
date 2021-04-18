<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\DB;
use App\Foods;

class FavoritesController extends Controller
{
    public function add(Request $request)
    {
        $id = auth('api')->user()->id;
        $food = $request->input('food');

        $fav = DB::table('favorites')->where('user', '=', "$id")->where('food', '=', "$food")->get()->first();
        if ($fav == null) {
            $values = array('user' => $id, 'food' => $food,
                'updated_at' => new \DateTime());
            $values['created_at'] = new \DateTime();
            DB::table('favorites')->insert($values);
        }else{
            $values = array('user' => $id, 'food' => $food,
                'updated_at' => new \DateTime());
            DB::table('favorites')
                ->where('user',$id)->where('food',$food)
                ->update($values);
        }

        $response = [
            'error' => '0',
        ];
        return response()->json($response, 200);
    }

    public function delete(Request $request)
    {
        $id = auth('api')->user()->id;
        $food = $request->input('food');

        DB::table('favorites')
            ->where('user', '=', "$id")->where('food', '=', "$food")
            ->delete();

        $response = [
            'error' => '0',
        ];
        return response()->json($response, 200);
    }

    public function get(Request $request)
    {
        $id = auth('api')->user()->id;

        $fav = DB::table('favorites')->where('user', '=', "$id")->get();

        $fcl = new Foods();

        // most popular
        $food = [];
        $restaurants = DB::table('restaurants')->get();
        $foods = DB::table('foods')->get();
        foreach ($fav as &$value) {
            foreach ($foods as &$value2) {
                if ($value->food == $value2->id) {
                    $value2 = $fcl->fill2($value2, $restaurants);
                    if ($value2 != null)
                        $food[] = $value2;
                }
            }
        }

        $currencies = DB::table('settings')->where('param', '=', "default_currencies")->get()->first()->value;

        $response = [
            'error' => '0',
            'favorites' => $fav,
            'food' => $food,
            'currency' => $currencies,
        ];
        return response()->json($response, 200);
    }
}
