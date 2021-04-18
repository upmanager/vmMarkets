<?php
namespace App\Http\Controllers\API\owner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use App\ImageUpload;
use App\UserInfo;

// 17.02.2021

class OwnerController extends Controller
{
    public function uploadImage(Request $request)
    {
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('images'),$imageName);
        $imageUpload = new ImageUpload();
        $imageUpload->vendor = Auth::id();
        $imageUpload->filename = $imageName;
        $imageUpload->save();
        return response()->json(['error' => '0', 'filename'=>$imageUpload->filename, 'id'=>$imageUpload->id, 'date'=> $imageUpload->updated_at->format('Y-m-d H:i:s')]);
    }

    public function totals(Request $request)
    {
        $temp = DB::table('settings')->where('param', '=', "default_currencyCode")->get()->first()->value;
        //
        if (UserInfo::getUserRoleId() == 2) {
            $userid = Auth::user()->id;
            $restCount = 0;
            $foodsCount = count(DB::table('foods')->where("vendor", $userid)->get());
            $ordersCount = count(DB::table('orders')->where("send", "1")->where("vendor", $userid)->get());
            $total = DB::table('orders')->where("send", "1")->where("vendor", $userid)->get()->sum('total');
            //
            $rest = DB::table('restaurants')->leftjoin("image_uploads", 'image_uploads.id', '=', 'restaurants.imageid')->
                where("restaurants.id", $userid)->
                select("image_uploads.filename")->get()->first();
            $food = DB::table('foods')->inRandomOrder()->
                    leftjoin("image_uploads", 'image_uploads.id', '=', 'foods.imageid')->
                    where("foods.vendor", $userid)->
                    select("image_uploads.filename")->get()->first();
            $order = DB::select("SELECT ordersdetails.image as filename FROM orders
                            LEFT JOIN ordersdetails ON orders.id=ordersdetails.order
                            WHERE vendor=$userid
                            ORDER BY rand() LIMIT 1;
                            ");
            if (count($order) > 0)
                $order = $order[0];
//                DB::table('ordersdetails')->inRandomOrder()->
//                where("vendor", $userid)->select("ordersdetails.image as filename")->get()->first();
        }

        return response()->json([
            'error' => '0',
            'restaurantImage' => (($rest == null || $rest->filename == null || $rest->filename == "") ? "noimage.png" : $rest->filename),
            'foodImage' => ($food == null ? "noimage.png" : $food->filename),
            'orderImage' => ($order == null ? "noimage.png" : $order->filename),
            'totals' => $total,
            'orders' => $ordersCount,
            'restaurants' => $restCount,
            'foods' => $foodsCount,
            'rightSymbol' => DB::table('settings')->where('param', '=', "rightSymbol")->get()->first()->value,
            'symbolDigits' => DB::table('currencies')->where('code', '=', $temp)->get()->first()->digits,
            'code' => DB::table('currencies')->where('code', '=', $temp)->get()->first()->symbol,
        ]);
    }

    public function getAppSettings(Request $request)
    {
        return response()->json([
            'error' => '0',
            'appLanguage' => DB::table('settings')->where('param', '=', "appLanguage")->get()->first()->value,
        ]);
    }



}
