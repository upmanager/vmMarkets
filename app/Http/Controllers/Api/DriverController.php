<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\DB;
use App\Lang;
use App\Http\Controllers\MessagingController;

class DriverController extends Controller
{
    public function setStatus(Request $request)
    {
        $id = auth('api')->user()->id;
        $active = $request->input('active'); // 1 or 0

        $values = array('active' => "$active",
            'updated_at' => new \DateTime());
        DB::table('users')->where('id',$id)->update($values);

        $response = [
            'error' => '0',
        ];
        return response()->json($response, 200);
    }

    public function getStatus(Request $request)
    {
        $id = auth('api')->user()->id;
        $active = DB::table('users')->where('id', '=', "$id")->get()->first();
        if ($active == null)
            $active = '1';
        else
            $active = $active->active;

        $response = [
            'error' => '0',
            'active' => $active,
        ];
        return response()->json($response, 200);
    }

    public function getDriverOrders(Request $request)
    {
        $id = auth('api')->user()->id;
        $orders = DB::table('orders')->where('driver', '=', "$id")->orderBy('updated_at', 'desc')->get();
        $ret = array();
        $currencies = DB::table('settings')->where('param', '=', "default_currencies")->get()->first()->value;
        foreach ($orders as &$value) {
            $restaurant = DB::table('restaurants')->where('id', '=', "$value->restaurant")->get()->first();
            if ($restaurant == null)
                continue;
            $user = DB::table('users')->where('id', '=', "$value->user")->get()->first();
            if ($user == null)
                continue;
            $array['currency'] = $currencies;
            $array['orderid'] = $value->id;
            $array['date'] = $value->updated_at;
            $array['status'] = $value->status;
            $array['statusName'] = DB::table('orderstatuses')->where('id', '=', "$value->status")->get()->first()->status;
            $array['total'] = $value->total;
            $array['restaurant'] = $restaurant->name;
            $array['address2'] = $restaurant->address;
            $array['address2Latitude'] = $restaurant->lat;
            $array['address2Longitude'] = $restaurant->lng;
            $ordersdetails = DB::table('ordersdetails')->where('order', '=', "$value->id")->get()->first();
            if ($ordersdetails != null) {
                $array['name'] = $ordersdetails->food;
                $array['image'] = $ordersdetails->image;
            }
            $ordertimes = DB::table('ordertimes')->where('order_id', '=', "$value->id")->get();
            $array['ordertimes'] = $ordertimes;
            //
            $array['address1'] = $value->address;
            $array['address1Latitude'] = $value->lat;
            $array['address1Longitude'] = $value->lng;
            $array['orderdetails'] = DB::table('ordersdetails')->where('order', '=', "$value->id")->get();
            $array['phone'] = $value->phone;
            $array['customerName'] = $user->name;
            $array['fee'] = $value->fee;
            $array['tax'] = $value->tax;
            $array['total'] = $value->total;
            $array['percent'] = $value->percent;

            $ret[] = $array;
        }

        // settings
        $rightSymbol = DB::table('settings')->where('param', '=', "rightSymbol")->get()->first()->value;
        $temp = DB::table('settings')->where('param', '=', "default_currencyCode")->get()->first()->value;
        $symbolDigits = DB::table('currencies')->where('code', '=', $temp)->get()->first()->digits;

        $response = [
            'error' => "0",
            'data'=> $ret,
            'settings' => [
                'rightSymbol' => $rightSymbol,
                'symbolDigits' => $symbolDigits,
            ],
        ];
        return response()->json($response, 200);
    }

    public function reject(Request $request)
    {
        $id_driver = auth('api')->user()->id;
        $id = $request->input('id');
        $comment = $request->input('comment') ?: "";

        $values = array('driver' => $id_driver, 'status' => "8", 'comment' => "$comment",
            'order_id' => $id,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime());
        DB::table('ordertimes')->insert($values);

        $response = [
            'error' => '0',
        ];
        return response()->json($response, 200);
    }

    public function accept(Request $request)
    {
        $id_driver = auth('api')->user()->id;
        $id = $request->input('id');

        $values = array('driver' => $id_driver, 'status' => "9", 'comment' => "",
            'order_id' => $id,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime());
        DB::table('ordertimes')->insert($values);

        $response = [
            'error' => '0',
        ];
        return response()->json($response, 200);
    }

    public function complete(Request $request)
    {
        $id_driver = auth('api')->user()->id;
        $id = $request->input('id');

        $values = array('driver' => $id_driver, 'status' => "10", 'comment' => "",
            'order_id' => $id,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime());
        DB::table('ordertimes')->insert($values);

        $values = array('status' => "5", 'updated_at' => new \DateTime());
        DB::table('orders')->where("id", "$id")->update($values);

        //
        $values = array(
            'order_id' => "$id", 'status' => 6, 'driver' => $id_driver,
            'comment' => "",
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        );
        DB::table('ordertimes')->insert($values);

        $status_text = DB::table('orderstatuses')->where('id',5)->get()->first()->status; // status = complete
        //
        // Send notification to user
        //
        $order = DB::table('orders')->where("id", "$id")->get()->first();
        $defaultImage = DB::table('settings')->where('param', '=', "notify_image")->get()->first()->value;
        if ($order != null) {
            $myRequest = new \Illuminate\Http\Request();
            $myRequest->setMethod('POST');
            $myRequest->request->add(['user' => $order->user]);
            $myRequest->request->add(['title' => Lang::get(470)]); // 'Order status changed',
            $myRequest->request->add(['text' => Lang::get(475) . $id . Lang::get(476) . $status_text]);  // "You order #",  ' was '
            $myRequest->request->add(['imageid' => $defaultImage]);
            MessagingController::sendNotify($myRequest);
        }
        //
        // send notifications to manager and admin
        //
        // Send Notifications to Admin
        //
        $userid = DB::table('users')->where('role',"1")->get()->first();
        if ($userid != null) {
            $myRequest = new \Illuminate\Http\Request();
            $myRequest->setMethod('POST');
            $myRequest->request->add(['user' => $userid->id]);
            $myRequest->request->add(['title' => Lang::get(470)]); // 'Order status changed',
            $myRequest->request->add(['text' => Lang::get(475) . $id . Lang::get(476) . $status_text]);  // "You order #",  ' was '
            $myRequest->request->add(['imageid' => $defaultImage]);
            MessagingController::sendNotify($myRequest);
        }

        $response = [
            'error' => '0',
        ];
        return response()->json($response, 200);
    }

    public function getStatistics(Request $request){
        $id = auth('api')->user()->id;
        $totals = DB::table('orders')->select('updated_at', 'fee', 'percent', 'total')->where('status', "=", 5)->where("driver", "$id")->orderBy('updated_at', 'desc')->get();
        $currencies = DB::table('settings')->where('param', '=', "default_currencies")->get()->first()->value;
        $response = [
            'error' => '0',
            'currencies' => $currencies,
            'data' => $totals
        ];
        return response()->json($response, 200);
    }

    public function settings(Request $request){
        $api = DB::table('settings')->where('param', '=', "mapapikey")->get()->first()->value;
        $appLanguage = DB::table('settings')->where('param', '=', "appLanguage")->get()->first()->value;
        $distanceUnit = DB::table('settings')->where('param', '=', "distanceUnit")->get()->first()->value;
        // settings
        $rightSymbol = DB::table('settings')->where('param', '=', "rightSymbol")->get()->first()->value;
        $temp = DB::table('settings')->where('param', '=', "default_currencyCode")->get()->first()->value;
        $symbolDigits = DB::table('currencies')->where('code', '=', $temp)->get()->first()->digits;
        //
        $response = [
            'error' => '0',
            'key' => $api,
            'appLanguage' => $appLanguage,
            'distanceUnit' => $distanceUnit,
            'otp' => DB::table('settings')->where('param', '=', "otp")->get()->first()->value,
            'rightSymbol' => $rightSymbol,
            'symbolDigits' => $symbolDigits,
        ];
        return response()->json($response, 200);
    }
}
