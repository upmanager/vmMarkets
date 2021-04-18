<?php

namespace App\Http\Controllers;

use App\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class BulkUploadController extends Controller
{
    public function load(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        return view('bulkUpload', []);
    }

    public function csvUpload(Request $request){
        $image = $request->file('file');
        $fileName = $image->getClientOriginalName();
        $image->move(public_path('images'), $fileName);
        return response()->json(['filename'=>$fileName]);
    }

    public function csvDestroy(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        return response()->json([]);
    }

    public function csvProcess(Request $request){
        $file = $request->input('file');
        $txt = file_get_contents('images/' . $file);
        $txt = str_replace(chr(0x52), '!!!!!', $txt);
        file_put_contents('images/' . $file, $txt);
        //
        $csv = array_map('str_getcsv', file('images/' . $file));
        $ret = array();
        $first = -1;
        $line = 0;

        $elements = null;
        foreach ($csv as &$data) {
            if ($first == -1) {
                $first = count($data);
                $elements = $data;
            }
            if ($first != -1)
                if (count($data) != $first)
                    return response()->json(['error'=>'1', 'text' => "Line $line: bad count. $first != " . count($data)]);
            $line++;
        }

        $products_add = 0;
        $line = 0;
        foreach ($csv as &$data) {
            $line++;
            if ($line == 1)
                continue;
            //
            $cat_id = 0;
            $name = "";
            $image = "";
            $price = 0;
            $discount_price = 0;
            $description = "";
            $variant1_name = "";
            $variant1_image = "";
            $variant1_price = 0;
            $variant1_dprice = 0;
            $variant2_name = "";
            $variant2_image = "";
            $variant2_price = 0;
            $variant2_dprice = 0;
            $variant3_name = "";
            $variant3_image = "";
            $variant3_price = 0;
            $variant3_dprice = 0;
            $variant4_name = "";
            $variant4_image = "";
            $variant4_price = 0;
            $variant4_dprice = 0;
            $variant5_name = "";
            $variant5_image = "";
            $variant5_price = 0;
            $variant5_dprice = 0;
            //
            $pos = 0;
            $ret[] = $data;
            foreach ($data as &$data2) {
                $ret[] = $data2 . "=" . $elements[$pos];
                switch ($elements[$pos]) {
                    case 'cat_id':
                        $cat_id = $data2;
                    break;
                    case 'name':
                        $name = $data2;
                    break;
                    case 'image':
                        $image = $data2;
                    break;
                    case 'price':
                        $price = $data2;
                    break;
                    case 'discount_price':
                        $discount_price = $data2;
                    break;
                    case 'description':
                        $description = $data2;
                    break;
                    case 'variant1_name':
                        $variant1_name = $data2;
                    break;
                    case 'variant1_image':
                        $variant1_image = $data2;
                    break;
                    case 'variant1_price':
                        $variant1_price = $data2;
                    break;
                    case 'variant1_dprice':
                        $variant1_dprice = $data2;
                    break;
                    case 'variant2_name':
                        $variant2_name = $data2;
                        break;
                    case 'variant2_image':
                        $variant2_image = $data2;
                        break;
                    case 'variant2_price':
                        $variant2_price = $data2;
                        break;
                    case 'variant2_dprice':
                        $variant2_dprice = $data2;
                        break;
                    case 'variant3_name':
                        $variant3_name = $data2;
                        break;
                    case 'variant3_image':
                        $variant3_image = $data2;
                        break;
                    case 'variant3_price':
                        $variant3_price = $data2;
                        break;
                    case 'variant3_dprice':
                        $variant3_dprice = $data2;
                        break;
                    case 'variant4_name':
                        $variant4_name = $data2;
                        break;
                    case 'variant4_image':
                        $variant4_image = $data2;
                        break;
                    case 'variant4_price':
                        $variant4_price = $data2;
                        break;
                    case 'variant4_dprice':
                        $variant4_dprice = $data2;
                        break;
                    case 'variant5_name':
                        $variant5_name = $data2;
                        break;
                    case 'variant5_image':
                        $variant5_image = $data2;
                        break;
                    case 'variant5_price':
                        $variant5_price = $data2;
                        break;
                    case 'variant5_dprice':
                        $variant5_dprice = $data2;
                        break;
                    default:
                        return response()->json(['error'=>'1', 'text' => "Unknown column: " . $elements[$pos]]);
                }
                $pos++;
            }
            if ($cat_id == 0)
                return response()->json(['error'=>'1', 'text' => "cat_id=" . $cat_id . ". line: " . $line]);
            if ($name == "")
                return response()->json(['error'=>'1', 'text' => "name is empty. line: " . $line]);
            //
            $imageUpload = new ImageUpload();
            $imageUpload->filename = $image;
            $imageUpload->vendor = Auth::id();
            $imageUpload->save();
            $imageid = $imageUpload->id;
            //
            $dpricet = str_ireplace(",", ".", $discount_price);
            if ($dpricet == "")
                $dpricet = 0;
            $values = array('name' => $name,
                'imageid' => $imageid,
                'price' => str_ireplace(",", ".", $price),
                'discountprice' => $dpricet,
                'desc' => $description,
                'restaurant' => Auth::user()->vendor,
                'category' => $cat_id,
                'ingredients' => "",
                'unit' => "",
                'packageCount' => 1,
                'weight' => 0,
                'canDelivery' => 1,
                'published' => 1,
                'stars' => '5',
                'extras' => 0,
                'nutritions' => 0,
                'vendor' => Auth::id(),
                'updated_at' => new \DateTime());
            $values['created_at'] = new \DateTime();
            DB::table('foods')->insert($values);
            $id = DB::getPdo()->lastInsertId();
            if ($id != 0)
                $products_add++;

            // variant 1
            $ret = BulkUploadController::productVariantsAdd($variant1_name, $variant1_price, $variant1_dprice, $variant1_image, $id, $image, $imageid, $ret);
            // variant 2
            $ret = BulkUploadController::productVariantsAdd($variant2_name, $variant2_price, $variant2_dprice, $variant2_image, $id, $image, $imageid, $ret);
            // variant 3
            $ret = BulkUploadController::productVariantsAdd($variant3_name, $variant3_price, $variant3_dprice, $variant3_image, $id, $image, $imageid, $ret);
            // variant 4
            $ret = BulkUploadController::productVariantsAdd($variant4_name, $variant4_price, $variant4_dprice, $variant4_image, $id, $image, $imageid, $ret);
            // variant 5
            $ret = BulkUploadController::productVariantsAdd($variant5_name, $variant5_price, $variant5_dprice, $variant5_image, $id, $image, $imageid, $ret);
        }
        return response()->json(['error'=>'0', 'count' => $products_add]);
    }

    public function productVariantsAdd($variant1_name, $variant1_price, $variant1_dprice, $variant1_image,
                $id, $image, $imageid, $ret){
        if ($variant1_name != "" && $variant1_price != 0){
            $imageid1 = 0;
            if ($variant1_image == $image)
                $imageid1 = $imageid;
            else {
                if ($variant1_image != "") {
                    $imageUpload = new ImageUpload();
                    $imageUpload->filename = $image;
                    $imageUpload->vendor = Auth::id();
                    $imageUpload->save();
                    $imageid1 = $imageUpload->$id;
                }
            }
            if ($imageid == null)
                $imageid1 = 0;
            $ret[] = "image=" . $imageid1;
            BulkUploadController::productVariantsAdd2($id, $variant1_name, $variant1_price, $variant1_dprice, $imageid1);
        }
        return $ret;
    }

    public function productVariantsAdd2($id, $name, $price, $dprice, $imageid)
    {
        if ($imageid == null)
            return;
        $dpricet = str_ireplace(",", ".", $dprice);
        if ($dpricet == "")
            $dpricet = 0;
        DB::table('variants')->insert(array(
            'food' => $id,
            'name' => $name,
            'imageid' => $imageid,
            'price' => str_ireplace(",", ".", $price),
            'dprice' => $dpricet,
            'updated_at' => new \DateTime(),
            'created_at' => new \DateTime(),
        ));
    }
}

