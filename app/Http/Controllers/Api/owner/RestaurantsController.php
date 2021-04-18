<?php
namespace App\Http\Controllers\API\owner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\DB;
use Auth;

// 17.02.2021

class RestaurantsController extends Controller
{
    public function restaurantsRet()
    {
        $rest_id = Auth::user()->vendor;
        $restaurants = DB::select("SELECT * FROM restaurants WHERE id=$rest_id");
        $images = DB::table('image_uploads')->select('id', 'filename')->get();
        return response()->json([
            'error' => '0',
            'id' => $rest_id,
            'restaurants' => $restaurants,
            'images' => $images,
        ], 200);
    }

    public function restaurantsSave(Request $request)
    {
        $editId = $request->input('editId') ?: "0";

        $values = array('name' => $request->input('name'),
            'imageid' => $request->input('imageid') ?: 0,
            'desc' => $request->input('desc') ?: "",
            'published' => $request->input('published'),
            'phone' => $request->input('phone') ?: "",
            'mobilephone' => $request->input('mobilephone') ?: "",
            'address' => $request->input('address') ?: "",
            'lat' => $request->input('lat') ?: "",
            'lng' => $request->input('lng') ?: "",
            'fee' => $request->input('fee') ?: 0,
            'percent' => $request->input('percent'),
            'openTimeMonday' => $request->input('openTimeMonday') ?: "",
            'closeTimeMonday' => $request->input('closeTimeMonday') ?: "",
            'openTimeTuesday' => $request->input('openTimeTuesday') ?: "",
            'closeTimeTuesday' => $request->input('closeTimeTuesday') ?: "",
            'openTimeWednesday' => $request->input('openTimeWednesday') ?: "",
            'closeTimeWednesday' => $request->input('closeTimeWednesday') ?: "",
            'openTimeThursday' => $request->input('openTimeThursday') ?: "",
            'closeTimeThursday' => $request->input('closeTimeThursday') ?: "",
            'openTimeFriday' => $request->input('openTimeFriday') ?: "",
            'closeTimeFriday' => $request->input('closeTimeFriday') ?: "",
            'openTimeSaturday' => $request->input('openTimeSaturday') ?: "",
            'closeTimeSaturday' => $request->input('closeTimeSaturday') ?: "",
            'openTimeSunday' => $request->input('openTimeSunday') ?: "",
            'closeTimeSunday' => $request->input('closeTimeSunday') ?: "",
            'area' => $request->input('area') ?: 0,
            'delivered' => '1',
            'updated_at' => new \DateTime());

        DB::table('restaurants')->where('id',$editId)->update($values);
        return RestaurantsController::restaurantsRet();
    }
}
