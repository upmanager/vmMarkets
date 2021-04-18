<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\DB;
use App\Lang;
use App\Http\Controllers\MessagingController;

class OrdersController extends Controller
{
    public function addToBasket(Request $request)
    {
        $id = auth('api')->user()->id;
        $order = DB::table('orders')->where('user', '=', "$id")->where('send', '=', "0")->get()->first();
        $orderid = 0;
        $send = $request->input('send');
        $pstatus = $request->input('pstatus');
        $tax = $request->input('tax');
        $restaurant = $request->input('restaurant');
        $method = $request->input('method');
        $hint = $request->input('hint');
        $address = $request->input('address');
        $phone = $request->input('phone');
        $total = $request->input('total') ?: 0;
        $lat = $request->input('lat');
        $lng = $request->input('lng');
        $couponName = $request->input('couponName') ?: "";
        $curbsidePickup = $request->input('curbsidePickup');

        $rest = DB::table('users')->where('vendor', $restaurant)->get()->first();
        if ($rest == null)
            return response()->json([
                'error' => "7",
            ], 200);

        $fee = DB::table('restaurants')->where('id', '=', "$restaurant")->get()->first()->fee;
        $percent = DB::table('restaurants')->where('id', '=', "$restaurant")->get()->first()->percent;
        $perkm = DB::table('restaurants')->where('id', '=', "$restaurant")->get()->first()->perkm;
        if ($perkm)
            $fee = $request->input('fee');
        if ($curbsidePickup == "true")
            $fee = "0";

        if ($order == null) {
            $values = array('driver' => "0",
                'address' => "$address", 'phone' => "$phone",
                'user' => "$id", 'status' => '1', 'pstatus' => "$pstatus",
                'tax' => "$tax", 'hint' => "$hint", 'active' => '1', 'restaurant' => "$restaurant",
                'method' => "$method", 'fee' => "$fee", 'send' => "$send",
                'lat' => "$lat", "lng" => "$lng",
                'total' => "$total",
                'percent' => "$percent",
                'perkm' => "$perkm",
                'curbsidePickup' => "$curbsidePickup",
                'couponName' => $couponName,
                'vendor' => $rest->id,
                'view' => 'false',
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            );
            DB::table('orders')->insert($values);
            $orderid = DB::getPdo()->lastInsertId();
        }else {
            $orderid = $order->id;
            $values = array(
                'address' => "$address", 'phone' => "$phone",
                'total' => "$total",
                'user' => "$id", 'status' => '1', 'pstatus' => "$pstatus",
                'tax' => "$tax", 'hint' => "$hint", 'active' => '1', 'restaurant' => "$restaurant",
                'lat' => "$lat", "lng" => "$lng",
                'percent' => "$percent",
                'perkm' => "$perkm",
                'method' => "$method", 'fee' => "$fee", 'send' => "$send",
                'couponName' => $couponName,
                'curbsidePickup' => "$curbsidePickup",
                'vendor' => $rest->id,
                'view' => 'false',
                'updated_at' => new \DateTime());
            DB::table('orders')
                ->where('id',$orderid)
                ->update($values);
        }

        DB::table('ordersdetails')->where('order', '=', $orderid)->delete();

        $data = $request->input('data');
        foreach ($data as &$value) {
            $food = $value['food'];
            $count = $value['count'];
            $foodprice = $value['foodprice'];
                $extras = $value['extras'];
            $extrascount = $value['extrascount'];
            $extrasprice = $value['extrasprice'];
            $foodid = $value['foodid'];
            $extrasid = $value['extrasid'];
            $image = $value['image'];
            $values = array(
                'order' => "$orderid", 'food' => "$food", 'count' => "$count",
                'foodprice' => "$foodprice", 'extras' => "$extras", 'extrascount' => "$extrascount", 'extrasprice' => "$extrasprice",
                'foodid' => "$foodid", 'extrasid' => "$extrasid", 'image' => "$image",
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            );
            DB::table('ordersdetails')->insert($values);
        }

        if ($send == '1'){
            $values = array(
                'order_id' => "$orderid", 'status' => 1, 'driver' => 0,
                'comment' => "",
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            );
            DB::table('ordertimes')->insert($values);
            //
            // send notifications to vendor and admin
            //
            // Send Notifications to Admin
            //
            $userid = DB::table('users')->where('role',"1")->get()->first();
            if ($userid != null) {
                $myRequest = new \Illuminate\Http\Request();
                $myRequest->setMethod('POST');
                $myRequest->request->add(['user' => $userid->id]);
                $myRequest->request->add(['title' => Lang::get(471)]); // 'New order arrived',
                $myRequest->request->add(['text' => Lang::get(472) . $orderid]);
                $defaultImage = DB::table('settings')->where('param', '=', "notify_image")->get()->first()->value;
                $myRequest->request->add(['imageid' => $defaultImage]);
                MessagingController::sendNotify($myRequest);
            }
            // vendor
            $userid = DB::table('users')->where('vendor', $restaurant)->get()->first();
            if ($userid != null) {
                $myRequest = new \Illuminate\Http\Request();
                $myRequest->setMethod('POST');
                $myRequest->request->add(['user' => $userid->id]);
                $myRequest->request->add(['title' => Lang::get(471)]); // 'New order arrived',
                $myRequest->request->add(['text' => Lang::get(472) . $orderid]);
                $defaultImage = DB::table('settings')->where('param', '=', "notify_image")->get()->first()->value;
                $myRequest->request->add(['imageid' => $defaultImage]);
                MessagingController::sendNotify($myRequest);
            }
        }

        return response()->json([
            'error' => "0",
            'orderid' => $orderid,
            'fee' => DB::table('restaurants')->where('id', '=', "$restaurant")->get()->first()->fee,
            'percent' => $percent,
            'perkm' => $perkm,
        ], 200);
    }

    public function resetBasket(Request $request){

        $id = auth('api')->user()->id;
        $order = DB::table('orders')->where('user', '=', "$id")->where('send', '=', "0")->get()->first();
        if ($order != null) {
            $id = $order->id;
            DB::table('ordersdetails')
                ->where('order',$id)
                ->delete();
        }
        $response = [
            'error' => "0",
            'data'=> null,
        ];
        return response()->json($response, 200);
    }

    public function getBasket(Request $request){

        $id = auth('api')->user()->id;
        // basket
        $order = DB::table('orders')->where('user', '=', "$id")->where('send', '=', "0")->get()->first();
        $orderdetails = null;
        $fee = null;
        $percent = null;
        $tax = 0;
        $perkm = "";
        if ($order != null) {
            $orderdetails = DB::table('ordersdetails')->where('order', '=', "$order->id")->get();
            foreach ($orderdetails as &$value) {
                $foodCategory = DB::table('foods')->where('id', '=', "$value->foodid")->get()->first();
                if ($foodCategory != null)
                    $value->category = $foodCategory->category;
            }
            $fee = DB::table('restaurants')->where('id', '=', $order->restaurant)->get()->first()->fee;
            $percent = DB::table('restaurants')->where('id', '=', $order->restaurant)->get()->first()->percent;
            $tax = $order->tax;
            $perkm = $order->perkm;
        }
        //$tax = DB::table('settings')->where('param', '=', "default_tax")->get()->first()->value;
        $currencies = DB::table('settings')->where('param', '=', "default_currencies")->get()->first()->value;

        $response = [
            'error' => '0',
            'currency' => $currencies,
            'default_tax' => $tax, //$tax,
            'order' => $order,
            'orderdetails' => $orderdetails,
            'fee' => $fee,
            'percent' => $percent,
            'perkm' => $perkm,
        ];
        return response()->json($response, 200);
    }

    public function deleteFromBasket(Request $request)
    {
        $orderid = $request->input('orderid');
        $id = $request->input('id');
        DB::table('ordersdetails')->where('order', '=', "$orderid")->where('foodid', '=', "$id")->delete();
    }

    public function setCountInBasket(Request $request)
    {
        $orderid = $request->input('orderid');
        $count = $request->input('count');
        $foodid = $request->input('foodid');
        DB::table('ordersdetails')->where('order', '=', "$orderid")->where('foodid', '=', "$foodid")->where('count', '!=', "0")->update(array('count' => $count, 'updated_at' => new \DateTime()));;
        DB::table('ordersdetails')->where('order', '=', "$orderid")->where('foodid', '=', "$foodid")->where('count', '=', "0")->update(array('extrascount' => $count, 'updated_at' => new \DateTime()));;
    }

    public function getOrders(Request $request)
    {
        $id = auth('api')->user()->id;
        $orders = DB::table('orders')->where('user', '=', "$id")->where('send', '=', "1")->
        orderBy('id', 'desc')->limit(100)->get();
        $ret = array();
        foreach ($orders as &$value) {
            $array['orderid'] = $value->id;
            $array['date'] = $value->updated_at;
            $array['tax'] = $value->tax;
            $array['fee'] = $value->fee;
            $array['perkm'] = $value->perkm;
            $array['percent'] = $value->percent;
            $array['status'] = $value->status;
            $array['statusName'] = DB::table('orderstatuses')->where('id', '=', "$value->status")->get()->first()->status;
            $array['total'] = $value->total;
            $restaurant = DB::table('restaurants')->where('id', '=', "$value->restaurant")->get()->first();
            if ($restaurant != null) {
                $array['restaurant'] = $restaurant->name;
                $ordersdetails = DB::table('ordersdetails')->where('order', '=', "$value->id")->get();
                $array['ordersdetails'] = $ordersdetails;
                $ordersdetails = $ordersdetails->first();
                if ($ordersdetails != null) {
                    $array['name'] = $ordersdetails->food;
                    $array['image'] = $ordersdetails->image;
                }
                $ordertimes = DB::table('ordertimes')->where('order_id', '=', "$value->id")->get();
                $array['ordertimes'] = $ordertimes;
                $array['curbsidePickup'] = $value->curbsidePickup;
                $array['arrived'] = $value->arrived;
                //
                $array['destLat'] = $value->lat;
                $array['destLng'] = $value->lng;
                $array['shopLat'] = $restaurant->lat;
                $array['shopLng'] = $restaurant->lng;
                $array['driver'] = $value->driver;
                //
                $ret[] = $array;
            }
        }
        $currencies = DB::table('settings')->where('param', '=', "default_currencies")->get()->first()->value;
        return response()->json([
            'error' => "0",
            'currency' => $currencies,
            'data'=> $ret,
        ], 200);
    }

}
