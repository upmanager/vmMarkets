<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\DB;

class CurbsidePickupController extends Controller
{
    public function arrived(Request $request)
    {
        $order_id = $request->input('order_id');

        $values = array('arrived' => "true",
            'updated_at' => new \DateTime());
        DB::table('orders')->where('id',$order_id)->update($values);

        //
        // save to OrdersTime details
        //
        $values = array(
            'order_id' => "$order_id", 'status' => "12", 'driver' => 0,
            'comment' => "",
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        );
        DB::table('ordertimes')->insert($values);

        $count = DB::table('settings')->where('param', '=', "ordersNotifications")->get()->first()->value;
        $count += 1;
        DB::table('settings')->where('param', '=', "ordersNotifications")->update(['value' => "$count", 'updated_at' => new \DateTime(),]);

        $response = [
            'error' => '0',
        ];
        return response()->json($response, 200);

    }
}
