<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Settings;
use App\Util;
use App\UserInfo;
use App\Currency;
use App\Lang;

class ProductsController extends Controller
{
    public function load(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        return view('products', []);
    }

    public function add(Request $request)
    {
        if (!Auth::check())
            return response()->json(['error' => "1"]);

        $id = $request->input('id');

        $moreimages = $request->input('moreimages') ?: "";
        $image = $request->input('image', "0");
        $name = $request->input('name') ?: "";
        $published = $request->input('published', "1");
        $delivered = $request->input('delivered', "1");
        $t = DB::table('users')->where('id', Auth::id())->get()->first();
        if ($t == null)
            return response()->json(['error' => "1"]);
        $restaurant = $t->vendor;
        $category = $request->input('category', "0");
        $price = $request->input('price') ?: 0.0;
        $discPrice = $request->input('discPrice') ?: 0.0;
        $unit = $request->input('unit') ?: "";
        $package = $request->input('package') ?: 0;
        $weight = $request->input('weight') ?: 0;
        $desc = $request->input('desc') ?: "";
        $ingredients = $request->input('ingredients') ?: "";
        $extras = $request->input('extras') ?: 0;
        $nutritions = $request->input('nutritions') ?: 0;

        $values = array('name' => $name,
            'imageid' => $image, 'price' => $price, 'discountprice' => $discPrice,
            'desc' => $desc, 'restaurant' => $restaurant, 'category' => $category,
            'ingredients' => $ingredients, 'unit' => $unit, 'packageCount' => $package,
            'weight' => $weight, 'canDelivery' => $delivered, 'published' => $published,
            'stars' => '5', 'extras' => $extras, 'nutritions' => $nutritions,
            'vendor' => Auth::id(),
            'images' => $moreimages,
            'updated_at' => new \DateTime());

        if ($id != "0") {
            DB::table('foods')
                ->where('id', $id)
                ->update($values);
        } else {
            $values['created_at'] = new \DateTime();
            DB::table('foods')->insert($values);
            $id = DB::getPdo()->lastInsertId();
        }

        $cacheRProducts = $request->input('cacheRProducts');
        if ($cacheRProducts != null) {
            foreach ($cacheRProducts as &$value) {
                ProductsController::rProductAdd2($id, $value['id']);
            }
        }
        $cacheVariant = $request->input('cacheVariant');
        if ($cacheVariant != null) {
            foreach ($cacheVariant as &$value) {
                ProductsController::productVariantsAdd2($id, $value['name'], $value['cprice'],
                    $value['cdprice'], $value['imageid']);
            }
        }

        return ProductsController::getOne($id);
    }

    public function delete(Request $request)
    {
        if (!Auth::check())
            return response()->json(['error' => "1"]);
        if (Settings::isDemoMode())
            return response()->json(['error'=>'2', 'text' => Lang::get(489)]); // This is demo app. You can't change this section
        $id = $request->input('id');
        DB::table('foods')->where('id', $id)->delete();
        return response()->json(['error' => '0']);
    }

    public function foodsGoPage(Request $request)
    {
        if (!Auth::check())
            return response()->json(['error' => "1"]);

        $search = $request->input('search') ?: "";
        $cat = $request->input('cat', "0");
        $page = $request->input('page') ?: 1;
        $count = $request->input('count', 10);
        $sortBy = $request->input('sortBy') ?: "id";
        $sortAscDesc = $request->input('sortAscDesc') ?: "asc";
        $sortPublished = $request->input('sortPublished', "1");
        $sortUnPublished = $request->input('sortUnPublished', "1");

        $offset = ($page - 1) * $count;

        $searchVisible = "";
        if ($sortPublished != '1' || $sortUnPublished != '1') {
            if ($sortPublished == '1')
                $searchVisible = "published = '1' AND ";
            if ($sortUnPublished == '1')
                $searchVisible = "published = '0' AND ";
        }
        if ($sortPublished == '0' && $sortUnPublished == '0')
            $searchVisible = "published='3' AND ";

        $searchCat = "";
        if ($cat != "0")
            $searchCat = " foods.category=" . $cat . " AND ";

        $vendor = Auth::id();
        $searchRest = " foods.vendor=$vendor AND ";

        $data = DB::select("SELECT foods.* FROM foods WHERE " . $searchRest . $searchVisible . $searchCat . " name LIKE '%" . $search . "%' ORDER BY " . $sortBy . " " . $sortAscDesc . " LIMIT " . $count . " OFFSET " . $offset);
        $total = count(DB::select("SELECT foods.* FROM foods  WHERE " . $searchRest . $searchVisible . $searchCat . " name LIKE '%" . $search . "%'"));

        $categories = DB::table('categories')->get();
        $restaurants = DB::table('restaurants')->get();
        foreach ($data as &$value) {
            $filename = DB::table('image_uploads')->where("id", $value->imageid)->get()->first();
            if ($filename != null)
                $value->filename = $filename->filename;
            else
                $value->filename = "noimage.png";
            $value->timeago = Util::timeago($value->updated_at);
            $value->categoryName = "";
            foreach ($categories as &$cat)
                if ($cat->id == $value->category)
                    $value->categoryName = $cat->name;
            $value->restaurantName = "";
            foreach ($restaurants as &$rest)
                if ($rest->id == $value->restaurant)
                    $value->restaurantName = $rest->name;
            $value->priceFull = Currency::makePrice($value->price);
            $value->discountPriceFull = Currency::makePrice($value->discountprice);
            // rating
            $pr = DB::table('foodsreviews')->where('food', $value->id)->get();
            $totals = 0;
            $count2 = 0;
            foreach ($pr as &$prv) {
                $totals += $prv->rate;
                $count2++;
            }
            $value->drating = 0;
            $value->rating = "";
            if ($count2 != 0) {
                $rating = $totals / $count2;
                $value->rating = sprintf('%0.1f', $rating);
                $value->drating = $rating;
            }
        }

        $t = $total / $count;
        if ($total % $count > 0)
            $t++;

        return response()->json(['error' => "0", 'idata' => $data, 'page' => $page, 'pages' => $t, 'total' => $total]);
    }

    public function foodGetInfo(Request $request)
    {
        if (!Auth::check())
            return response()->json(['error' => "1"]);

        $id = $request->input('id', "0");
        if ($id == "0")
            return response()->json(['error' => "4"]);

        return ProductsController::getOne($id);
    }

    public function getOne($id)
    {
        $food = DB::table('foods')->where("id", $id)->get()->first();

        $filename = DB::table('image_uploads')->where("id", $food->imageid)->get()->first();
        if ($filename != null)
            $food->filename = $filename->filename;
        else
            $food->filename = "noimage.png";
        $food->images_files[] = array('id' => $food->imageid,
            'filename' => $food->filename,
            'size' => filesize("images/" . $food->filename)
        );

        $food->timeago = Util::timeago($food->updated_at);

        $categories = DB::table('categories')->get();
        $restaurants = DB::table('restaurants')->get();

        $food->categoryName = "";
        foreach ($categories as &$cat)
            if ($cat->id == $food->category)
                $food->categoryName = $cat->name;
        $food->restaurantName = "";
        foreach ($restaurants as &$rest)
            if ($rest->id == $food->restaurant)
                $food->restaurantName = $rest->name;
        $food->priceFull = Currency::makePrice($food->price);
        $food->discountPriceFull = Currency::makePrice($food->discountprice);
        $food->drating = 0;
        $food->rating = "";
        // all images
        if ($food->images != null){
            $images = explode(",", $food->images);
            foreach ($images as &$data) {
                $filename = DB::table('image_uploads')->where("id", $data)->get()->first();
                if ($filename != null)
                    $filename = $filename->filename;
                else
                    $filename = "noimage.png";
                $food->images_files[] = array('id' => $data,
                    'filename' => $filename,
                    'size' => filesize("images/" . $filename)
                );
            }
        }

        return response()->json(['error' => "0", 'data' => $food,
            'variants' => ProductsController::variantsGet($id),
            'rp' => ProductsController::rProductsGet($id)
        ]);
    }

    public function productVariantsAdd(Request $request){
        $id = $request->input('id');
        $name = $request->input('name');
        $price = $request->input('price');
        $dprice = $request->input('dprice');
        $imageid = $request->input('imageid');
        return ProductsController::productVariantsAdd2($id, $name, $price, $dprice, $imageid);
    }

    public function productVariantsAdd2($id, $name, $price, $dprice, $imageid)
    {
        if ($id != 0) {
            DB::table('variants')->insert(array(
                'food' => $id,
                'name' => $name,
                'imageid' => $imageid,
                'price' => $price,
                'dprice' => $dprice,
                'updated_at' => new \DateTime(),
                'created_at' => new \DateTime(),
            ));
        }else{
            $image = DB::table("image_uploads")->where("id", $imageid)->get()->first();
            if ($image != null) $image = $image->filename;
            else $image = "noimage.png";
            return response()->json(['error' => "0",
                'data' => array(
                    'name' => $name,
                    'price' => Currency::makePrice($price),
                    'cprice' => $price,
                    'dprice' => Currency::makePrice($dprice),
                    'cdprice' => $dprice,
                    'timeago' => " ",
                    'image' => $image,
                    'imageid' => $imageid
                ),
            ]);
        }

        return response()->json(['error' => "0",
            'data' => ProductsController::variantsGet($id),
        ]);
    }

    public static function variantsGet($id){
        $data = DB::select("SELECT variants.*,
                                        CASE
                                             WHEN image_uploads.id IS NULL THEN \"noimage.png\"
                                             ELSE image_uploads.filename
                                        END AS image
                                        FROM variants
                                        LEFT JOIN image_uploads ON variants.imageid=image_uploads.id
                                        WHERE food=$id ORDER BY variants.price ASC
                                        ");
        foreach ($data as &$value){
            $value->timeago = Util::timeago($value->updated_at);
            $value->price = Currency::makePrice($value->price);
            $value->dprice = Currency::makePrice($value->dprice);
        }
        return $data;
    }

    public function productVariantsDelete(Request $request)
    {
        $id = $request->input('id');
        if (Settings::isDemoMode()){
            return response()->json(['error'=>'1', 'text' => Lang::get(489)]); // This is demo app. You can't change this section
        }
        DB::table('variants')->where('id', $id)->delete();
        return response()->json(['error' => "0",
            'data' => ProductsController::variantsGet($request->input('parent')),
        ]);
    }

    public function rProductsDelete(Request $request)
    {
        $id = $request->input('id');
        if (Settings::isDemoMode()){
            return response()->json(['error'=>'1', 'text' => Lang::get(489)]); // This is demo app. You can't change this section
        }
        DB::table('rproducts')->where('rp', $id)->delete();
        return response()->json(['error' => "0",
            'data' => ProductsController::rProductsGet($request->input('parent')),
        ]);
    }

    public function rProductAdd(Request $request)
    {
        $id = $request->input('id');
        $rp = $request->input('rp');
        return ProductsController::rProductAdd2($id, $rp);
    }

    public static function rProductAdd2($id, $rp){
        if ($id != 0) {
            DB::table('rproducts')->insert(array(
                'food' => $id,
                'rp' => $rp,
            ));
        }else{
            $data = DB::select("SELECT foods.id, foods.name, foods.price,
                                        CASE
                                             WHEN image_uploads.id IS NULL THEN \"noimage.png\"
                                             ELSE image_uploads.filename
                                        END AS image
                                        FROM foods
                                        LEFT JOIN image_uploads ON foods.imageid=image_uploads.id
                                        WHERE foods.id=$rp
                                        ");
            foreach ($data as &$value)
                $value->price = Currency::makePrice($value->price);
            return response()->json(['error' => "0", 'nowrite' => '1',
                'data' => $data
            ]);
        }

        return response()->json(['error' => "0",
            'data' => ProductsController::rProductsGet($id),
        ]);
    }

    public static function rProductsGet($id){
        $data = DB::select("SELECT foods.id, foods.name, foods.price,
                                        CASE
                                             WHEN image_uploads.id IS NULL THEN \"noimage.png\"
                                             ELSE image_uploads.filename
                                        END AS image
                                        FROM rproducts
                                        LEFT JOIN foods ON foods.id=rproducts.rp
                                        LEFT JOIN image_uploads ON foods.imageid=image_uploads.id
                                        WHERE rproducts.food=$id ORDER BY rproducts.updated_at DESC
                                        ");
        foreach ($data as &$value)
            $value->price = Currency::makePrice($value->price);

        return $data;
    }
}

