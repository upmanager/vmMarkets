<?php
namespace App\Http\Controllers\API\owner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Lang;
use App\Http\Controllers\MessagingController;
use App\Http\Controllers\OrdersController;
use App\UserInfo;

class OwnerOrdersController extends Controller
{
    public function ordersList()
    {
        $vendor = Auth::user()->id;
        $orders = DB::select("SELECT orders.*, users.name as userName FROM orders
                    LEFT JOIN users ON users.id=orders.user
                    WHERE orders.send='1' AND orders.vendor=$vendor
                    ORDER BY orders.updated_at DESC
                    LIMIT 100
                    ");
        foreach ($orders as &$value) {
            $value->ordersData = DB::table('ordersdetails')->where("order", $value->id)->get();
            $rest = DB::table('restaurants')->where("id", $value->restaurant)->get()->first();
            if ($rest != null){
                $value->addressDest = $rest->address;
                $value->latRest = $rest->lat;
                $value->lngRest = $rest->lng;
            }
        }
        $orderStatus = DB::table('orderstatuses')->get();
        $currencies = DB::table('settings')->where('param', '=', "default_currencies")->get()->first()->value;
        $rightSymbol = DB::table('settings')->where('param', '=', "rightSymbol")->get()->first()->value;
        $distanceUnit = DB::table('settings')->where('param', '=', "distanceUnit")->get()->first()->value;
        $drivers = DB::table('users')->where('role', '=', "3")->select('id', 'name', 'imageid', 'phone', 'active')->get();
        $response = [
            'error' => '0',
            'id' => "",
            'orders' => $orders,
            'orderStatus' => $orderStatus,
            'currency' => $currencies,
            'rightSymbol' => $rightSymbol,
            'distanceUnit' => $distanceUnit,
            'googleApiKey' => DB::table('settings')->where('param', '=', "mapapikey")->get()->first()->value,
            'drivers' => $drivers,
            'images' => DB::table('image_uploads')->select('id', 'filename')->get(),
        ];
        return response()->json($response, 200);
    }

    public function changeStatus(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        $order_id = $request->input('id') ?: "";
        $status = $request->input('status') ?: "";

        $values = array('status' => $status, 'updated_at' => new \DateTime());
        DB::table('orders')->where('id',$order_id)->update($values);

        //
        // Send Notifications to user
        //
        $myRequest = new \Illuminate\Http\Request();
        $myRequest->setMethod('POST');
        $id = DB::table('orders')->where('id',$order_id)->get()->first()->user;
        $myRequest->request->add(['user' => $id]);
        $myRequest->request->add(['title' => Lang::get(470)]); // 'Order status changed',
        $status_text = DB::table('orderstatuses')->where('id',$status)->get()->first()->status;
        $myRequest->request->add(['text' => Lang::get(475) . $order_id . Lang::get(476) . $status_text]);  // "You order #",  ' was '
        $defaultImage = DB::table('settings')->where('param', '=', "notify_image")->get()->first()->value;
        $myRequest->request->add(['imageid' => $defaultImage]);
        MessagingController::sendNotify($myRequest);

        //
        // save to OrdersTime details
        //
        $values = array(
            'order_id' => "$order_id", 'status' => "$status", 'driver' => 0,
            'comment' => "",
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        );
        DB::table('ordertimes')->insert($values);

        return response()->json([
            'error'=>"1",
        ]);
    }

    public function changeDriver(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        return OrdersController::changeDriver($request);
    }
}
