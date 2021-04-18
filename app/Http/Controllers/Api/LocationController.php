<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\DB;
use App\Foods;

class LocationController extends Controller
{
    public function sendLocation(Request $request){
        $id = auth('api')->user()->id;

        $values = array(
            'lat' => $request->input('lat'),
            'lng' => $request->input('lng'),
            'speed' => $request->input('speed'),
            'updated_at' => new \DateTime(),
            'created_at' => new \DateTime()
        );
        DB::table('users')->where('id', $id)->update($values);
    }

    public function getDriverLocation(Request $request){
        $driver = $request->input('driver') ?: 0;
        $t = DB::table('users')->where('id', $driver)->get()->first();
        $lat = 0;
        $lng = 0;
        if ($t != null){
            $lat = $t->lat;
            $lng = $t->lng;
        }
        return response()->json([
            'error' => "0",
            'lat' => $lat,
            'lng' => $lng,
        ], 200);
    }

}


