<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\DB;
use App\Foods;
use App\Category;

class RestaurantsController extends Controller
{
    public function getMain(Request $request)
    {
        $restaurants = DB::table('restaurants')->get();
        $fcl = new Foods();

        // top foods
        $top = [];
        $topfoods = DB::table('topfoods')->get();
        foreach ($topfoods as &$value) {
            $value2 = DB::table('foods')->where('id',$value->food)->get()->first();
            if ($value2 != null) {
                $value2 = $fcl->fill2($value2, $restaurants);
                if ($value2 != null)
                    $top[] = $value2;
            }
        }

        // restaurants
        $restaurants2 = DB::table('restaurants')->leftjoin("image_uploads", 'image_uploads.id', '=', 'restaurants.imageid')->
                        select('restaurants.*', 'image_uploads.filename as image')->where('published', '1')->get();
        foreach ($restaurants2 as &$value)
            if ($value->image == "")
                $value->image = "noimage.png";

        // top restaurants
        $toprestaurants = DB::table('toprestaurants')
                    ->join("restaurants", 'restaurants.id', '=', 'toprestaurants.restaurant')
                    ->leftjoin("image_uploads", 'image_uploads.id', '=', 'restaurants.imageid')
                    ->select('restaurants.*', 'image_uploads.filename as image')->where('published', '1')->get();
        foreach ($toprestaurants as &$value)
            if ($value->image == "")
                $value->image = "noimage.png";

        // categories
        $categories = DB::table('categories')->where('visible', '=', "1")->leftjoin("image_uploads", 'image_uploads.id', '=', 'categories.imageid')->
                        select('categories.*', 'image_uploads.filename as image')->orderBy('categories.updated_at', 'desc')->get();
        foreach ($categories as &$value)
            if ($value->image == "")
                $value->image = "noimage.png";

        // most popular
        $fav = [];
        $favorites = DB::table('favorites')->selectRaw('food, count(*) as result')->groupBy('food')->orderBy('result', 'desc')->limit(10)->get();
        foreach ($favorites as &$value) {
            $value2 = DB::table('foods')->where('id',$value->food)->get()->first();
            if ($value2 != null) {
                $value2 = $fcl->fill2($value2, $restaurants);
                if ($value2 != null)
                    $fav[] = $value2;
            }
        }

        // restaurantsreviews
        $restaurantsreviews = DB::table('restaurantsreviews')->
            leftjoin("users", 'users.id', '=', 'restaurantsreviews.user')->
            leftjoin("image_uploads", 'image_uploads.id', '=', 'users.imageid')->
            select('restaurantsreviews.*', 'image_uploads.filename as image', 'users.name as name')->
            orderBy('restaurantsreviews.updated_at', 'desc')->
            limit(5)->get();
        foreach ($restaurantsreviews as &$value)
            if ($value->image == "")
                $value->image = "noimage.png";

        // settings
        $currencies = DB::table('settings')->where('param', '=', "default_currencies")->get()->first()->value;
        $tax = DB::table('settings')->where('param', '=', "default_tax")->get()->first()->value;

        //
        // payments
        //
        $StripeEnable = DB::table('settings')->where('param', '=', "StripeEnable")->get()->first()->value;
        $stripeKey = DB::table('settings')->where('param', '=', "stripeKey")->get()->first()->value;
        $stripeSecretKey = DB::table('settings')->where('param', '=', "stripeSecretKey")->get()->first()->value;
        $razEnable = DB::table('settings')->where('param', '=', "razEnable")->get()->first()->value;
        $razKey = DB::table('settings')->where('param', '=', "razKey")->get()->first()->value;
        $razName = DB::table('settings')->where('param', '=', "razName")->get()->first()->value;
        $cashEnable = DB::table('settings')->where('param', '=', "cashEnable")->get()->first()->value;
        $code = DB::table('settings')->where('param', '=', "default_currencyCode")->get()->first()->value;

        // settings
        $rightSymbol = DB::table('settings')->where('param', '=', "rightSymbol")->get()->first()->value;
        $temp = DB::table('settings')->where('param', '=', "default_currencyCode")->get()->first()->value;
        $symbolDigits = DB::table('currencies')->where('code', '=', $temp)->get()->first()->digits;

        $row1 = DB::table('settings')->where('param', '=', "row1")->get()->first()->value;
        $row1visible = DB::table('settings')->where('param', '=', "row1visible")->get()->first()->value;
        if ($row1visible == "false") $row1 = "";
        $row2 = DB::table('settings')->where('param', '=', "row2")->get()->first()->value;
        $row2visible = DB::table('settings')->where('param', '=', "row2visible")->get()->first()->value;
        if ($row2visible == "false") $row2 = "";
        $row3 = DB::table('settings')->where('param', '=', "row3")->get()->first()->value;
        $row3visible = DB::table('settings')->where('param', '=', "row3visible")->get()->first()->value;
        if ($row3visible == "false") $row3 = "";
        $row4 = DB::table('settings')->where('param', '=', "row4")->get()->first()->value;
        $row4visible = DB::table('settings')->where('param', '=', "row4visible")->get()->first()->value;
        if ($row4visible == "false") $row4 = "";
        $row5 = DB::table('settings')->where('param', '=', "row5")->get()->first()->value;
        $row5visible = DB::table('settings')->where('param', '=', "row5visible")->get()->first()->value;
        if ($row5visible == "false") $row5 = "";
        $row6 = DB::table('settings')->where('param', '=', "row6")->get()->first()->value;
        $row6visible = DB::table('settings')->where('param', '=', "row6visible")->get()->first()->value;
        if ($row6visible == "false") $row6 = "";
        $row7 = DB::table('settings')->where('param', '=', "row7")->get()->first()->value;
        $row7visible = DB::table('settings')->where('param', '=', "row7visible")->get()->first()->value;
        if ($row7visible == "false") $row7 = "";
        $row8 = DB::table('settings')->where('param', '=', "row8")->get()->first()->value;
        $row8visible = DB::table('settings')->where('param', '=', "row8visible")->get()->first()->value;
        if ($row8visible == "false") $row8 = "";
        $row9 = DB::table('settings')->where('param', '=', "row9")->get()->first()->value;
        $row9visible = DB::table('settings')->where('param', '=', "row9visible")->get()->first()->value;
        if ($row9visible == "false") $row9 = "";
        $row10 = DB::table('settings')->where('param', '=', "row10")->get()->first()->value;
        $row10visible = DB::table('settings')->where('param', '=', "row10visible")->get()->first()->value;
        if ($row10visible == "false") $row10 = "";
        $row11 = DB::table('settings')->where('param', '=', "row11")->get()->first()->value;
        $row11visible = DB::table('settings')->where('param', '=', "row11visible")->get()->first()->value;
        if ($row11visible == "false") $row11 = "";
        $rows = [$row1, $row2, $row3, $row4, $row5, $row6, $row7, $row8, $row9, $row10, $row11];

        // colors
        $iconColorWhiteMode = DB::table('settings')->where('param', '=', "iconColorWhiteMode")->get()->first()->value;
        if ($iconColorWhiteMode == "") $iconColorWhiteMode = null; else $iconColorWhiteMode = "ff".$iconColorWhiteMode;
        $restaurantTitleColor = DB::table('settings')->where('param', '=', "restaurantTitleColor")->get()->first()->value;
        if ($restaurantTitleColor == "") $restaurantTitleColor = null; else $restaurantTitleColor = "ff".$restaurantTitleColor;
        $restaurantBackgroundColor = DB::table('settings')->where('param', '=', "restaurantBackgroundColor")->get()->first()->value;
        if ($restaurantBackgroundColor == "") $restaurantBackgroundColor = null; else $restaurantBackgroundColor = "ff".$restaurantBackgroundColor;
        $dishesTitleColor = DB::table('settings')->where('param', '=', "dishesTitleColor")->get()->first()->value;
        if ($dishesTitleColor == "") $dishesTitleColor = null; else $dishesTitleColor = "ff".$dishesTitleColor;
        $dishesBackgroundColor = DB::table('settings')->where('param', '=', "dishesBackgroundColor")->get()->first()->value;
        if ($dishesBackgroundColor == "") $dishesBackgroundColor = null; else $dishesBackgroundColor = "ff".$dishesBackgroundColor;
        $categoriesTitleColor = DB::table('settings')->where('param', '=', "categoriesTitleColor")->get()->first()->value;
        if ($categoriesTitleColor == "") $categoriesTitleColor = null; else $categoriesTitleColor = "ff".$categoriesTitleColor;
        $categoriesBackgroundColor = DB::table('settings')->where('param', '=', "categoriesBackgroundColor")->get()->first()->value;
        if ($categoriesBackgroundColor == "") $categoriesBackgroundColor = null; else $categoriesBackgroundColor = "ff".$categoriesBackgroundColor;
        $searchBackgroundColor = DB::table('settings')->where('param', '=', "searchBackgroundColor")->get()->first()->value;
        if ($searchBackgroundColor == "") $searchBackgroundColor = null; else $searchBackgroundColor = "ff".$searchBackgroundColor;
        $reviewTitleColor = DB::table('settings')->where('param', '=', "reviewTitleColor")->get()->first()->value;
        if ($reviewTitleColor == "") $reviewTitleColor = null; else $reviewTitleColor = "ff".$reviewTitleColor;
        $reviewBackgroundColor = DB::table('settings')->where('param', '=', "reviewBackgroundColor")->get()->first()->value;
        if ($reviewBackgroundColor == "") $reviewBackgroundColor = null; else $reviewBackgroundColor = "ff".$reviewBackgroundColor;

        // theme
        $mainColor = DB::table('settings')->where('param', '=', "mainColor")->get()->first()->value;
        if ($mainColor == "") $mainColor = null; else $mainColor = "ff".$mainColor;
        $radius = DB::table('settings')->where('param', '=', "radius")->get()->first()->value;
        if ($radius != "") $radius = (int) $radius; else $radius = null;
        $darkMode = DB::table('settings')->where('param', '=', "darkMode")->get()->first()->value;
        if ($darkMode == "") $darkMode = null;

        $categoryCardWidth = DB::table('settings')->where('param', '=', "categoryCardWidth")->get()->first()->value;
        if ($categoryCardWidth != "") $categoryCardWidth = (int) $categoryCardWidth; else $categoryCardWidth = null;
        $categoryCardHeight = DB::table('settings')->where('param', '=', "categoryCardHeight")->get()->first()->value;
        if ($categoryCardHeight != "") $categoryCardHeight = (int) $categoryCardHeight; else $categoryCardHeight = null;
        $shadow = DB::table('settings')->where('param', '=', "shadow")->get()->first()->value;
        if ($shadow != "") $shadow = (int) $shadow; else $shadow = null;
        $iconColorDarkMode = DB::table('settings')->where('param', '=', "iconColorDarkMode")->get()->first()->value;
        if ($iconColorDarkMode == "") $iconColorDarkMode = null;

        $restaurantCardWidth = DB::table('settings')->where('param', '=', "restaurantCardWidth")->get()->first()->value;
        if ($restaurantCardWidth != "") $restaurantCardWidth = (int) $restaurantCardWidth; else $restaurantCardWidth = null;
        $restaurantCardHeight = DB::table('settings')->where('param', '=', "restaurantCardHeight")->get()->first()->value;
        if ($restaurantCardHeight != "") $restaurantCardHeight = (int) $restaurantCardHeight; else $restaurantCardHeight = null;
        $restaurantCardTextSize = DB::table('settings')->where('param', '=', "restaurantCardTextSize")->get()->first()->value;
        if ($restaurantCardTextSize != "") $restaurantCardTextSize = (int) $restaurantCardTextSize; else $restaurantCardTextSize = null;
        $restaurantCardTextColor = DB::table('settings')->where('param', '=', "restaurantCardTextColor")->get()->first()->value;
        if ($restaurantCardTextColor == "") $restaurantCardTextColor = null; else $restaurantCardTextColor = "ff".$restaurantCardTextColor;
        $dishesCardHeight = DB::table('settings')->where('param', '=', "dishesCardHeight")->get()->first()->value;
        if ($dishesCardHeight != "") $dishesCardHeight = (int) $dishesCardHeight; else $dishesCardHeight = null;
        $oneInLine = DB::table('settings')->where('param', '=', "oneInLine")->get()->first()->value;
        if ($oneInLine == "") $oneInLine = null;
        $categoryCardCircle = DB::table('settings')->where('param', '=', "categoryCardCircle")->get()->first()->value;
        if ($categoryCardCircle == "") $categoryCardCircle = null;
        $topRestaurantCardHeight = DB::table('settings')->where('param', '=', "topRestaurantCardHeight")->get()->first()->value;
        if ($topRestaurantCardHeight != "") $topRestaurantCardHeight = (int) $topRestaurantCardHeight; else $topRestaurantCardHeight = null;
        $bottomBarType = DB::table('settings')->where('param', '=', "bottomBarType")->get()->first()->value;
        $bottomBarColor = DB::table('settings')->where('param', '=', "bottomBarColor")->get()->first()->value;
        if ($bottomBarColor == "") $bottomBarColor = null; else $bottomBarColor = "ff".$bottomBarColor;
        $titleBarColor = DB::table('settings')->where('param', '=', "titleBarColor")->get()->first()->value;
        if ($titleBarColor == "") $titleBarColor = null; else $titleBarColor = "ff".$titleBarColor;
        $mapapikey = DB::table('settings')->where('param', '=', "mapapikey")->get()->first()->value;
        $typeFoods = DB::table('settings')->where('param', '=', "typeFoods")->get()->first()->value;
        //
        $walletEnable = DB::table('settings')->where('param', '=', "walletEnable")->get()->first()->value;
        // paypal
        $payPalEnable = DB::table('settings')->where('param', '=', "payPalEnable")->get()->first()->value;
        $payPalSandBox = DB::table('settings')->where('param', '=', "payPalSandBox")->get()->first()->value;
        $payPalClientId = DB::table('settings')->where('param', '=', "payPalClientId")->get()->first()->value;
        $payPalSecret = DB::table('settings')->where('param', '=', "payPalSecret")->get()->first()->value;
        // paystack
        $payStackEnable = DB::table('settings')->where('param', '=', "payStackEnable")->get()->first()->value;
        $payStackKey = DB::table('settings')->where('param', '=', "payStackKey")->get()->first()->value;
        // yandxKassa
        $yandexKassaEnable = DB::table('settings')->where('param', '=', "yandexKassaEnable")->get()->first()->value;
        $yandexKassaShopId = DB::table('settings')->where('param', '=', "yandexKassaShopId")->get()->first()->value;
        $yandexKassaClientAppKey = DB::table('settings')->where('param', '=', "yandexKassaClientAppKey")->get()->first()->value;
        $yandexKassaSecretKey = DB::table('settings')->where('param', '=', "yandexKassaSecretKey")->get()->first()->value;
        // instamojo
        $instamojoEnable = DB::table('settings')->where('param', '=', "instamojoEnable")->get()->first()->value;
        $instamojoApiKey = DB::table('settings')->where('param', '=', "instamojoApiKey")->get()->first()->value;
        $instamojoPrivateToken = DB::table('settings')->where('param', '=', "instamojoPrivateToken")->get()->first()->value;
        $instamojoSandBoxMode = DB::table('settings')->where('param', '=', "instamojoSandBoxMode")->get()->first()->value;
        //
        $distanceUnit = DB::table('settings')->where('param', '=', "distanceUnit")->get()->first()->value;
        $appLanguage = DB::table('settings')->where('param', '=', "appLanguage")->get()->first()->value;
        //
        $coupons = DB::table('coupons')->where('dateStart', '<=', date("Y-m-d"))->where('dateEnd', '>=', date("Y-m-d"))->where('published', '=', '1')->get();

        $response = [
            'success' => true,
            'restaurants'=> $restaurants2,
            'toprestaurants' => $toprestaurants,
            'categories'=> $categories,
            'favorites' => $fav,
            'top_foods' => $top,
            'default_tax' => $tax,
            'currency' => $currencies,
            'restaurantsreviews' => $restaurantsreviews,
            'coupons' => $coupons,
            'payments' => [
                'StripeEnable' => $StripeEnable,
                'stripeKey' => $stripeKey,
                'stripeSecretKey' => $stripeSecretKey,
                'razEnable' => $razEnable,
                'razKey' => $razKey,
                'razName' => $razName,
                'cashEnable' => $cashEnable,
                'code' => $code,
                'payPalEnable' => $payPalEnable,
                'payPalSandBox' => $payPalSandBox,
                'payPalClientId' => $payPalClientId,
                'payPalSecret' => $payPalSecret,
                'payStackEnable' => $payStackEnable,
                'payStackKey' => $payStackKey,
                'yandexKassaEnable' => $yandexKassaEnable,
                'yandexKassaShopId' => $yandexKassaShopId,
                'yandexKassaClientAppKey' => $yandexKassaClientAppKey,
                'yandexKassaSecretKey' => $yandexKassaSecretKey,
                'instamojoEnable' => $instamojoEnable,
                'instamojoSandBoxMode' => $instamojoSandBoxMode,
                'instamojoApiKey' => $instamojoApiKey,
                'instamojoPrivateToken' => $instamojoPrivateToken
            ],
            'settings' => [
                'currency' => $currencies,
                'darkMode' => $darkMode,
                'rightSymbol' => $rightSymbol,
                'walletEnable' => $walletEnable,
                'symbolDigits' => $symbolDigits,
                'radius' => $radius,
                'shadow' => $shadow,
                'rows' => $rows,
                'mainColor' => $mainColor,
                'iconColorWhiteMode' => $iconColorWhiteMode,
                'iconColorDarkMode' => $iconColorDarkMode,
                'restaurantCardWidth' => $restaurantCardWidth,
                'restaurantCardHeight' => $restaurantCardHeight,
                'restaurantBackgroundColor' => $restaurantBackgroundColor,
                'restaurantCardTextSize' => $restaurantCardTextSize,
                'restaurantCardTextColor' => $restaurantCardTextColor,
                'restaurantTitleColor' => $restaurantTitleColor,
                'dishesTitleColor' => $dishesTitleColor,
                'dishesBackgroundColor' => $dishesBackgroundColor,
                'dishesCardHeight' => $dishesCardHeight,
                'oneInLine' => $oneInLine,
                'categoriesTitleColor' => $categoriesTitleColor,
                'categoriesBackgroundColor' => $categoriesBackgroundColor,
                'categoryCardWidth' => $categoryCardWidth,
                'categoryCardHeight' => $categoryCardHeight,
                'searchBackgroundColor' => $searchBackgroundColor,
                'reviewTitleColor' => $reviewTitleColor,
                'reviewBackgroundColor' => $reviewBackgroundColor,
                'categoryCardCircle' => $categoryCardCircle,
                'topRestaurantCardHeight' => $topRestaurantCardHeight,
                'bottomBarType' => $bottomBarType,
                'bottomBarColor' => $bottomBarColor,
                'titleBarColor' => $titleBarColor,
                'mapapikey' => $mapapikey,
                'typeFoods' => $typeFoods,
                'distanceUnit' => $distanceUnit,
                'appLanguage' => $appLanguage,
                'copyright' => DB::table('docs')->where('param', '=', "copyright_ca")->get()->first()->value,
                'copyright_text' => DB::table('docs')->where('param', '=', "copyright_text")->get()->first()->value,
                'about' => DB::table('docs')->where('param', '=', "about_ca")->get()->first()->value,
                'faq' => DB::table('settings')->where('param', '=', "faq_ca")->get()->first()->value,
                'otp' => DB::table('settings')->where('param', '=', "otp")->get()->first()->value,
                'delivering' => DB::table('settings')->where('param', '=', "delivering")->get()->first()->value,
                'curbsidePickup' => DB::table('settings')->where('param', '=', "curbsidePickup")->get()->first()->value,
                'coupon' => DB::table('settings')->where('param', '=', "coupon")->get()->first()->value,
                'deliveringTime' => DB::table('settings')->where('param', '=', "deliveringTime")->get()->first()->value,
                'delivery' => DB::table('docs')->where('param', '=', "delivery_ca")->get()->first()->value,
                'privacy' => DB::table('docs')->where('param', '=', "privacy_ca")->get()->first()->value,
                'terms' => DB::table('docs')->where('param', '=', "terms_ca")->get()->first()->value,
                'refund' => DB::table('docs')->where('param', '=', "refund_ca")->get()->first()->value,
                'refund_text_name' => DB::table('docs')->where('param', '=', "refund_text_name")->get()->first()->value,
                'about_text_name' => DB::table('docs')->where('param', '=', "about_text_name")->get()->first()->value,
                'delivery_text_name' => DB::table('docs')->where('param', '=', "delivery_text_name")->get()->first()->value,
                'privacy_text_name' => DB::table('docs')->where('param', '=', "privacy_text_name")->get()->first()->value,
                'terms_text_name' => DB::table('docs')->where('param', '=', "terms_text_name")->get()->first()->value,
                'banner1CardHeight' => DB::table('settings')->where('param', '=', "banner1CardHeight")->get()->first()->value,
                'banner2CardHeight' => DB::table('settings')->where('param', '=', "banner2CardHeight")->get()->first()->value,
                'googleLogin_ca' => DB::table('settings')->where('param', '=', "googleLogin_ca")->get()->first()->value,
                'facebookLogin_ca' => DB::table('settings')->where('param', '=', "facebookLogin_ca")->get()->first()->value,
                'defaultLat' => DB::table('settings')->where('param', '=', "defaultLat")->get()->first()->value,
                'defaultLng' => DB::table('settings')->where('param', '=', "defaultLng")->get()->first()->value,
                'skin' => DB::table('settings')->where('param', "skin")->get()->first()->value,
            ],
        ];
        return response()->json($response, 200);
    }


    public function getRestaurant(Request $request)
    {
        // restaurant id
        $rest = $request->input('restaurant');

        // restaurant
        $restaurant = DB::table('restaurants')->where('id',$rest)->get()->first();
        $item = DB::table('image_uploads')->where('id',$restaurant->imageid)->get()->first();
        if ($item != null)
            $restaurant->image = $item->filename;
        else
            $restaurant->image = "noimage.png";

        // categories
        $categories = Category::getCat($restaurant->id);

        // restaurantsreviews
        $restaurantsreviews = DB::table('restaurantsreviews')->where('restaurant',$restaurant->id)->
            leftjoin("users", 'users.id', '=', 'restaurantsreviews.user')->
            leftjoin("image_uploads", 'image_uploads.id', '=', 'users.imageid')->
            select('restaurantsreviews.*', 'image_uploads.filename as image', 'users.name as name')->get();
        foreach ($restaurantsreviews as &$value7) {
            if ($value7->image == null || $value7->image == "")
                $value7->image = "noimage.png";
        }
        // banners
        $user = DB::table('users')->where('vendor', $restaurant->id)->get()->first();
        $vendorid = 0;
        if ($user != null)
            $vendorid = $user->id;
        $banners = DB::table('banners')->where("visible", "1")->
                where("banners.vendor", $vendorid)->leftjoin("image_uploads", 'image_uploads.id', '=', 'banners.imageid')->
                select('banners.id', 'banners.type', 'banners.details', 'banners.position', 'image_uploads.filename as image')->get();
        $foodsBanners = array();
        foreach ($banners as &$value) {
            if ($value->image == "")
                $value->image = "noimage.png";
            if ($value->type == "1")  // food
                $foodsBanners[] = DB::table('foods')->where('id',$value->details)->get()->first();
        }

        $fcl = new Foods();
        // dishes
        $fav = [];
        $restaurants = DB::table('restaurants')->get();
        $foods = DB::table('foods')->where('restaurant',"=", $restaurant->id)->get();
        foreach ($foods as &$value2) {
            //$item = DB::table('image_uploads')->where('id',$value2->imageid)->get()->first();
            //if ($value2 != null) {
                $value2 = $fcl->fill2($value2, $restaurants);
                if ($value2 != null)
                    $fav[] = $value2;
            //}
        }
        foreach ($foodsBanners as &$value2) {
            $value2 = $fcl->fill2($value2, $restaurants);
            if ($value2 != null)
                $fav[] = $value2;
        }

        $currencies = DB::table('settings')->where('param', '=', "default_currencies")->get()->first()->value;
        $tax = DB::table('settings')->where('param', '=', "default_tax")->get()->first()->value;

        $response = [
            'error' => '0',
            'ver' => '2',
            'restaurant'=> $restaurant,
            'categories'=> $categories,
            'foods' => $fav,
            'default_tax' => $tax,
            'currency' => $currencies,
            'restaurantsreviews' => $restaurantsreviews,
            'banner1' => $banners
        ];
        return response()->json($response, 200);
    }

    public function getSecondStep(Request $request)
    {
        $banner1 = DB::table('banners')->where("visible", "1")->
        where("visible", "1")->where("banners.vendor", "0")->
            where("position", "1")->leftjoin("image_uploads", 'image_uploads.id', '=', 'banners.imageid')->
            select('banners.id', 'banners.type', 'banners.details', 'banners.position', 'image_uploads.filename as image')->get();
        $foods = array();
        foreach ($banner1 as &$value) {
            if ($value->image == "")
                $value->image = "noimage.png";
            if ($value->type == "1")  // food
                $foods[] = DB::table('foods')->where('id',$value->details)->get()->first();
        }
        $banner2 = DB::table('banners')->where("visible", "1")->
            where("position", "2")->where("banners.vendor", "0")->
            leftjoin("image_uploads", 'image_uploads.id', '=', 'banners.imageid')->
            select('banners.id', 'banners.type', 'banners.details', 'banners.position', 'image_uploads.filename as image')->get();
        foreach ($banner2 as &$value) {
            if ($value->image == "")
                $value->image = "noimage.png";
            if ($value->type == "1")  // food
                $foods[] = DB::table('foods')->where('id',$value->details)->get()->first();
        }
        $f = new Foods();

        $foods = RestaurantsController::getCategories($foods);

        $response = [
            'error' => '0',
            'banner1' => $banner1,
            'banner2' => $banner2,
            'foods' => $f->fill($foods),
        ];
        return response()->json($response, 200);
    }

    public function getCategories($foods){

        // categories
        $categoriesAll = DB::table('categories')->where("visible", "1")->where("vendor", "0")->get();
        foreach ($categoriesAll as &$value) {
            if ($value->parent != "0" && $value->parent != "-1")
                continue;
            $data = DB::table('foods')->where('category', $value->id)->where('published', '1')->orderBy('foods.updated_at', 'desc')->limit(10)->get();
            if (count($data) != 0){
                foreach ($data as &$value2) {
                    if (!in_array($value2, $foods)) {
                        $foods[] = $value2;
                    }
                }
            }else{
                $cats = DB::table('categories')->where("parent", $value->id)->get();
                foreach ($cats as &$value3) {
                    $data = DB::table('foods')->where('category', $value3->id)->where('published', '1')->orderBy('foods.updated_at', 'desc')->limit(10)->get();
                    if ($data != null){
                        foreach ($data as &$value2) {
                            if (!in_array($value2, $foods)) {
                                $foods[] = $value2;
                            }
                        }
                    }
                }
            }
        }
        return $foods;
    }

    public function getFoods(Request $request){
        $f = new Foods();

        $need = $request->input('need');

        $foods = array();
        foreach ($need as &$value) {
            $foods[] = DB::table('foods')->where('id', $value)->get()->first();
        }

        $response = [
            'error' => '0',
            'foods' => $f->fill($foods),
        ];
        return response()->json($response, 200);
    }
}
