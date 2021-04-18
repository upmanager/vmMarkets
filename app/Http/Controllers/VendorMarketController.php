<?php

namespace App\Http\Controllers;

use App\Lang;
use App\Settings;
use App\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class VendorMarketController extends Controller
{
    public function load(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');


        $text = $request->input('text');
        if ($text != null)
            return VendorMarketController::view("green", $text);
        return VendorMarketController::view("", "");
    }

    public function view($green, $text){

        $market = DB::table('restaurants')->leftjoin("image_uploads", 'image_uploads.id', '=', 'restaurants.imageid')->
            where('restaurants.id', Auth::user()->vendor)->
            select('restaurants.*', 'image_uploads.filename as image')->get()->first();

        if ($market->image == "")
            $market->image = "noimage.png";

        // rating
        $pr = DB::table('restaurantsreviews')->where('restaurant', Auth::user()->vendor)->get();
        $totals = 0;
        $count = 0;
        foreach ($pr as &$prv) {
            $totals += $prv->rate;
            $count++;
        }
        $drating = 0;
        $rating = "";
        if ($count != 0) {
            $rating = $totals / $count;
            $rating = sprintf('%0.1f', $rating);
            $drating = $rating;
        }
        //

        return view('vendorMarket', ['data' => $market,
            'petani' => DB::table('image_uploads')->where('vendor', Auth::id())->get(),
            'rating' => $rating, 'drating' => $drating
        ]);
    }

    public function add(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        VendorMarketController::dataMassive($request, 1);
        return VendorMarketController::view("green", "Data Saved successfully");
    }

    function dataMassive(Request $request, $update){
        $id = $request->input('id');
        $name = $request->input('name') ?: "";
        $visible = $request->input('visible');
        if ($visible == 'on') $visible = true;  else $visible = false;
        $delivered = $request->input('delivered');
        if ($delivered == 'on') $delivered = true; else $delivered = false;
        $text = $request->input('desc') ?: "";
        $text = preg_replace('/[\r\n\t]/', '', $text);
        $image = $request->input('image') ?: 0;
        $address = $request->input('address') ?: "";
        $phone = $request->input('phone') ?: "";
        $mobilephone = $request->input('mobilephone') ?: "";
        $lat = $request->input('lat') ?: "";
        $lng = $request->input('lng') ?: "";
        $fee = $request->input('fee') ?: 0.0;
        $percent = $request->input('percent');
        $tax = $request->input('tax');
        if ($percent == 'on') $percent = true;  else $percent = false;
        $perkm = $request->input('perkm');
        if ($perkm == 'on') $perkm = true;  else $perkm = false;
        // opened time
        $openTimeMonday = $request->input('openTimeMonday') ?: "";
        $closeTimeMonday = $request->input('closeTimeMonday') ?: "";
        $openTimeTuesday = $request->input('openTimeTuesday') ?: "";
        $closeTimeTuesday = $request->input('closeTimeTuesday') ?: "";
        $openTimeWednesday = $request->input('openTimeWednesday') ?: "";
        $closeTimeWednesday = $request->input('closeTimeWednesday') ?: "";
        $openTimeThursday = $request->input('openTimeThursday') ?: "";
        $closeTimeThursday = $request->input('closeTimeThursday') ?: "";
        $openTimeFriday = $request->input('openTimeFriday') ?: "";
        $closeTimeFriday = $request->input('closeTimeFriday') ?: "";
        $openTimeSaturday = $request->input('openTimeSaturday') ?: "";
        $closeTimeSaturday = $request->input('closeTimeSaturday') ?: "";
        $openTimeSunday = $request->input('openTimeSunday') ?: "";
        $closeTimeSunday = $request->input('closeTimeSunday') ?: "";
        //
        $area = $request->input('area') ?: 30;
        $minAmount = $request->input('minAmount') ?: 0;
        //
        $values = array('name' => $name, 'imageid' => $image, 'desc' => "$text",
            //'published' => $visible,
            'phone' => $phone, 'mobilephone' => $mobilephone, 'address' => $address, 'lat' => $lat, 'lng' => $lng,
            'fee' => $fee,
            'percent' => $percent,
            'openTimeMonday' => $openTimeMonday, 'closeTimeMonday' => $closeTimeMonday,
            'openTimeTuesday' => $openTimeTuesday, 'closeTimeTuesday' => $closeTimeTuesday,
            'openTimeWednesday' => $openTimeWednesday, 'closeTimeWednesday' => $closeTimeWednesday,
            'openTimeThursday' => $openTimeThursday, 'closeTimeThursday' => $closeTimeThursday,
            'openTimeFriday' => $openTimeFriday, 'closeTimeFriday' => $closeTimeFriday,
            'openTimeSaturday' => $openTimeSaturday, 'closeTimeSaturday' => $closeTimeSaturday,
            'openTimeSunday' => $openTimeSunday, 'closeTimeSunday' => $closeTimeSunday,
            'area' => $area,
            'minAmount' => $minAmount,
            'tax' => $tax,
            'perkm' => $perkm,
            'delivered' => $delivered, 'updated_at' => new \DateTime());

        if ($update == 2){
            DB::table('restaurants')
                ->where('id',$id)
                ->update($values);
        }
        if ($update == 1){
            $values['created_at'] = new \DateTime();
            DB::table('restaurants')->insert($values);
        }
    }

    public function edit(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');
        VendorMarketController::dataMassive($request, 2);
        $str = Lang::get(578); // Restaurant Updated successfully";
        return \Redirect::to('/vendormarket?text=' . $str);
    }

    //
    // Reviews
    //
    public function delete(Request $request){
        if (!Auth::check())
            return response()->json(['error' => "1"]);
        if (Settings::isDemoMode())
            return response()->json(['error'=>'2', 'text' => Lang::get(489)]); // This is demo app. You can't change this section
        $id = $request->input('id');
        DB::table('restaurantsreviews')->where('id',$id)->delete();
        return response()->json(['error'=>'0']);
    }

    public function GoPage(Request $request)
    {
        if (!Auth::check())
            return response()->json(['error'=>"1"]);

        $search = $request->input('search') ? : "";
        $page = $request->input('page') ? : 1;
        $count = $request->input('count', 10);
        $sortBy = $request->input('sortBy') ? : "id";
        $sortAscDesc = $request->input('sortAscDesc') ? : "asc";

        $offset = ($page - 1) * $count;

        $vend = "";
        if (Auth::user()->role == 2) {
            $vendorId = Auth::user()->vendor;
            $vend = "restaurant=$vendorId AND";
        }

        $datas = DB::select("SELECT * FROM restaurantsreviews WHERE $vend 'desc' LIKE '%$search%' ORDER BY $sortBy  $sortAscDesc LIMIT $count OFFSET $offset");
        $total = count(DB::select("SELECT * FROM restaurantsreviews WHERE $vend 'desc' LIKE '%$search%' " ));

        foreach ($datas as &$data) {
            $data->timeago = Util::timeago($data->updated_at);
            //
            $user = DB::table('users')->where('id', $data->user)->get()->first();
            if ($user != null)
                $data->userName = $user->name;
            else
                $data->userName = Lang::get(577); // Deleted
            //
            $market = DB::table('restaurants')->where('id', $data->restaurant)->get()->first();
            if ($market != null)
                $data->marketName = $market->name;
            else
                $data->marketName = Lang::get(577); // Deleted
        }

        $t = $total/$count;
        if ($total%$count > 0)
            $t++;

        return response()->json(['error'=>"0", 'idata' => $datas, 'page' => $page, 'pages' => $t, 'total' => $total]);
    }

}
