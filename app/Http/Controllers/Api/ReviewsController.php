<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\DB;

class ReviewsController extends Controller
{
    public function foodAdd(Request $request)
    {
        $id = auth('api')->user()->id;
        $food = $request->input('food') ?: 0;
        $rate = $request->input('rate') ?: 5;
        $desc = $request->input('desc') ?: "";

        if (count(DB::table('foodsreviews')->where("food", $food)->where("user", $id)->get()) != 0)
            DB::table('foodsreviews')->where("food", $food)->where("user", $id)->delete();

        $values = array('user' => $id, 'food' => $food, 'rate' => $rate, 'desc' => $desc,
            'updated_at' => new \DateTime());
        $values['created_at'] = new \DateTime();
        DB::table('foodsreviews')->insert($values);

        $date = new \DateTime();
        $date2 = $date->format('Y-m-d H:i:s');

        $reviews  = DB::table('foodsreviews')->where('food', $food)->
            join("users", 'users.id', '=', 'foodsreviews.user')->
            leftjoin("image_uploads", 'image_uploads.id', '=', 'users.imageid')->
            select('foodsreviews.*', 'image_uploads.filename as image', 'users.name as userName')->get();
        foreach ($reviews as &$value7) {
            if ($value7->image == null || $value7->image == "")
                $value7->image = "noimage.png";
        }

        $response = [
            'error' => '0',
            'date' => $date2,
            'reviews' => $reviews
        ];
        return response()->json($response, 200);
    }

    public function restaurantAdd(Request $request)
    {
        $id = auth('api')->user()->id;
        $restaurant = $request->input('restaurant') ?: 0;
        $rate = $request->input('rate') ?: 5;
        $desc = $request->input('desc') ?: "";

        if (count(DB::table('restaurantsreviews')->where("restaurant", $restaurant)->where("user", $id)->get()) != 0)
            DB::table('restaurantsreviews')->where("restaurant", $restaurant)->where("user", $id)->delete();

        $values = array('user' => $id, 'restaurant' => $restaurant, 'rate' => $rate, 'desc' => $desc,
            'updated_at' => new \DateTime());
        $values['created_at'] = new \DateTime();
        DB::table('restaurantsreviews')->insert($values);

        $date = new \DateTime();
        $date2 = $date->format('Y-m-d H:i:s');

        $reviews = DB::table('restaurantsreviews')->where('restaurant', $restaurant)->
            leftjoin("users", 'users.id', '=', 'restaurantsreviews.user')->
            leftjoin("image_uploads", 'image_uploads.id', '=', 'users.imageid')->
            select('restaurantsreviews.*', 'image_uploads.filename as image', 'users.name as name')->get();
        foreach ($reviews as &$value7) {
            if ($value7->image == null || $value7->image == "")
                $value7->image = "noimage.png";
        }

        $response = [
            'error' => '0',
            'date' => $date2,
            'reviews' => $reviews
        ];
        return response()->json($response, 200);
    }


}
