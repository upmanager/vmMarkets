<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class UIController extends Controller
{
    public function caLayout(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');
        $row1 = DB::table('settings')->where('param', '=', "row1")->get()->first()->value;
        $row1visible = DB::table('settings')->where('param', '=', "row1visible")->get()->first()->value;
        $row2 = DB::table('settings')->where('param', '=', "row2")->get()->first()->value;
        $row2visible = DB::table('settings')->where('param', '=', "row2visible")->get()->first()->value;
        $row3 = DB::table('settings')->where('param', '=', "row3")->get()->first()->value;
        $row3visible = DB::table('settings')->where('param', '=', "row3visible")->get()->first()->value;
        $row4 = DB::table('settings')->where('param', '=', "row4")->get()->first()->value;
        $row4visible = DB::table('settings')->where('param', '=', "row4visible")->get()->first()->value;
        $row5 = DB::table('settings')->where('param', '=', "row5")->get()->first()->value;
        $row5visible = DB::table('settings')->where('param', '=', "row5visible")->get()->first()->value;
        $row6 = DB::table('settings')->where('param', '=', "row6")->get()->first()->value;
        $row6visible = DB::table('settings')->where('param', '=', "row6visible")->get()->first()->value;
        $row7 = DB::table('settings')->where('param', '=', "row7")->get()->first()->value;
        $row7visible = DB::table('settings')->where('param', '=', "row7visible")->get()->first()->value;

        return view('caLayout', ['row1' => $row1, 'row2' => $row2, 'row3' => $row3, 'row4' => $row4, 'row5' => $row5,
            'row1visible' => $row1visible, 'row2visible' => $row2visible, 'row3visible' => $row3visible,
            'row4visible' => $row4visible, 'row5visible' => $row5visible,
            'row6' => $row6, 'row6visible' => $row6visible,
            'row7' => $row7, 'row7visible' => $row7visible,
            'row8' => DB::table('settings')->where('param', '=', "row8")->get()->first()->value,
            'row8visible' => DB::table('settings')->where('param', '=', "row8visible")->get()->first()->value,
            'row9' => DB::table('settings')->where('param', '=', "row9")->get()->first()->value,
            'row9visible' => DB::table('settings')->where('param', '=', "row9visible")->get()->first()->value,
            'row10' => DB::table('settings')->where('param', '=', "row10")->get()->first()->value,
            'row10visible' => DB::table('settings')->where('param', '=', "row10visible")->get()->first()->value,
            'row11' => DB::table('settings')->where('param', '=', "row11")->get()->first()->value,
            'row11visible' => DB::table('settings')->where('param', '=', "row11visible")->get()->first()->value,
        ]);
    }

    public function caLayout_change(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        DB::table('settings')->where('param', '=', "row1")->update(['value' => $request->input('row1'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where('param', '=', "row2")->update(['value' => $request->input('row2'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where('param', '=', "row3")->update(['value' => $request->input('row3'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where('param', '=', "row4")->update(['value' => $request->input('row4'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where('param', '=', "row5")->update(['value' => $request->input('row5'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where('param', '=', "row6")->update(['value' => $request->input('row6'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where('param', '=', "row7")->update(['value' => $request->input('row7'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where('param', '=', "row8")->update(['value' => $request->input('row8'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where('param', '=', "row9")->update(['value' => $request->input('row9'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where('param', '=', "row10")->update(['value' => $request->input('row10'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where('param', '=', "row11")->update(['value' => $request->input('row11'), 'updated_at' => new \DateTime(),]);
        //
        DB::table('settings')->where('param', '=', "row1visible")->update(['value' => $request->input('visible1'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where('param', '=', "row2visible")->update(['value' => $request->input('visible2'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where('param', '=', "row3visible")->update(['value' => $request->input('visible3'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where('param', '=', "row4visible")->update(['value' => $request->input('visible4'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where('param', '=', "row5visible")->update(['value' => $request->input('visible5'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where('param', '=', "row6visible")->update(['value' => $request->input('visible6'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where('param', '=', "row7visible")->update(['value' => $request->input('visible7'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where('param', '=', "row8visible")->update(['value' => $request->input('visible8'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where('param', '=', "row9visible")->update(['value' => $request->input('visible9'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where('param', '=', "row10visible")->update(['value' => $request->input('visible10'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where('param', '=', "row11visible")->update(['value' => $request->input('visible11'), 'updated_at' => new \DateTime(),]);

        $response = ['error' => "0"];
        return response()->json($response, 200);
    }

    public function caLayoutColors(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');
        $iconColorWhiteMode = DB::table('settings')->where('param', '=', "iconColorWhiteMode")->get()->first()->value;
        $restaurantTitleColor = DB::table('settings')->where('param', '=', "restaurantTitleColor")->get()->first()->value;
        $dishesBackgroundColor = DB::table('settings')->where('param', '=', "dishesBackgroundColor")->get()->first()->value;
        $dishesTitleColor = DB::table('settings')->where('param', '=', "dishesTitleColor")->get()->first()->value;
        $restaurantBackgroundColor = DB::table('settings')->where('param', '=', "restaurantBackgroundColor")->get()->first()->value;
        $categoriesTitleColor = DB::table('settings')->where('param', '=', "categoriesTitleColor")->get()->first()->value;
        $categoriesBackgroundColor = DB::table('settings')->where('param', '=', "categoriesBackgroundColor")->get()->first()->value;
        $searchBackgroundColor = DB::table('settings')->where('param', '=', "searchBackgroundColor")->get()->first()->value;
        $reviewTitleColor = DB::table('settings')->where('param', '=', "reviewTitleColor")->get()->first()->value;
        $reviewBackgroundColor = DB::table('settings')->where('param', '=', "reviewBackgroundColor")->get()->first()->value;
        $bottomBarColor = DB::table('settings')->where('param', '=', "bottomBarColor")->get()->first()->value;
        $titleBarColor = DB::table('settings')->where('param', '=', "titleBarColor")->get()->first()->value;

        return view('caLayoutColors', [
            'iconColorWhiteMode' => $iconColorWhiteMode,
            'restaurantTitleColor' => $restaurantTitleColor,
            'restaurantBackgroundColor' => $restaurantBackgroundColor,
            'dishesBackgroundColor' => $dishesBackgroundColor,
            'dishesTitleColor' => $dishesTitleColor,
            'categoriesTitleColor' => $categoriesTitleColor,
            'categoriesBackgroundColor' => $categoriesBackgroundColor,
            'searchBackgroundColor' => $searchBackgroundColor,
            'reviewTitleColor' => $reviewTitleColor,
            'reviewBackgroundColor' => $reviewBackgroundColor,
            'bottomBarColor' => $bottomBarColor,
            'titleBarColor' => $titleBarColor,
        ]);
    }

    public function caLayout_changeColors(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');
        $iconColorWhiteMode = $request->input('iconColorWhiteMode') ?: "";
        DB::table('settings')->where('param', '=', "iconColorWhiteMode")->update(['value' => "$iconColorWhiteMode", 'updated_at' => new \DateTime(),]);
        $restaurantTitleColor = $request->input('restaurantTitleColor') ?: "";
        DB::table('settings')->where('param', '=', "restaurantTitleColor")->update(['value' => "$restaurantTitleColor", 'updated_at' => new \DateTime(),]);
        $restaurantBackgroundColor = $request->input('restaurantBackgroundColor') ?: "";
        DB::table('settings')->where('param', '=', "restaurantBackgroundColor")->update(['value' => "$restaurantBackgroundColor", 'updated_at' => new \DateTime(),]);
        $dishesBackgroundColor = $request->input('dishesBackgroundColor') ?: "";
        DB::table('settings')->where('param', '=', "dishesBackgroundColor")->update(['value' => "$dishesBackgroundColor", 'updated_at' => new \DateTime(),]);
        $dishesTitleColor = $request->input('dishesTitleColor') ?: "";
        DB::table('settings')->where('param', '=', "dishesTitleColor")->update(['value' => "$dishesTitleColor", 'updated_at' => new \DateTime(),]);
        $categoriesTitleColor = $request->input('categoriesTitleColor') ?: "";
        DB::table('settings')->where('param', '=', "categoriesTitleColor")->update(['value' => "$categoriesTitleColor", 'updated_at' => new \DateTime(),]);
        $categoriesBackgroundColor = $request->input('categoriesBackgroundColor') ?: "";
        DB::table('settings')->where('param', '=', "categoriesBackgroundColor")->update(['value' => "$categoriesBackgroundColor", 'updated_at' => new \DateTime(),]);
        $searchBackgroundColor = $request->input('searchBackgroundColor') ?: "";
        DB::table('settings')->where('param', '=', "searchBackgroundColor")->update(['value' => "$searchBackgroundColor", 'updated_at' => new \DateTime(),]);
        $reviewTitleColor = $request->input('reviewTitleColor') ?: "";
        DB::table('settings')->where('param', '=', "reviewTitleColor")->update(['value' => "$reviewTitleColor", 'updated_at' => new \DateTime(),]);
        $reviewBackgroundColor = $request->input('reviewBackgroundColor') ?: "";
        DB::table('settings')->where('param', '=', "reviewBackgroundColor")->update(['value' => "$reviewBackgroundColor", 'updated_at' => new \DateTime(),]);
        $bottomBarColor = $request->input('bottomBarColor') ?: "";
        DB::table('settings')->where('param', '=', "bottomBarColor")->update(['value' => "$bottomBarColor", 'updated_at' => new \DateTime(),]);
        $titleBarColor = $request->input('titleBarColor') ?: "";
        DB::table('settings')->where('param', '=', "titleBarColor")->update(['value' => "$titleBarColor", 'updated_at' => new \DateTime(),]);

        $response = ['error' => "0"];
        return response()->json($response, 200);
    }

    public function caTheme(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');
        $mainColor = DB::table('settings')->where('param', '=', "mainColor")->get()->first()->value;
        $radius = DB::table('settings')->where('param', '=', "radius")->get()->first()->value;
        $shadow = DB::table('settings')->where('param', '=', "shadow")->get()->first()->value;
        $darkMode = DB::table('settings')->where('param', '=', "darkMode")->get()->first()->value;
        $bottomBarType = DB::table('settings')->where('param', '=', "bottomBarType")->get()->first()->value;
        $appLanguage = DB::table('settings')->where('param', '=', "appLanguage")->get()->first()->value;

        return view('caTheme', [
            'mainColor' => $mainColor,
            'radius' => $radius,
            'shadow' => $shadow,
            'darkMode' => $darkMode,
            'bottomBarType' => $bottomBarType,
            'appLanguage' => $appLanguage,
            'about' => DB::table('docs')->where('param', '=', "about_ca")->get()->first()->value,
            'delivery' => DB::table('docs')->where('param', '=', "delivery_ca")->get()->first()->value,
            'privacy' => DB::table('docs')->where('param', '=', "privacy_ca")->get()->first()->value,
            'terms' => DB::table('docs')->where('param', '=', "terms_ca")->get()->first()->value,
            'refund' => DB::table('docs')->where('param', '=', "refund_ca")->get()->first()->value,
            'faq' => DB::table('settings')->where('param', '=', "faq_ca")->get()->first()->value,
            'google' => DB::table('settings')->where('param', '=', "googleLogin_ca")->get()->first()->value,
            'facebook' => DB::table('settings')->where('param', '=', "facebookLogin_ca")->get()->first()->value,
            'otp' => DB::table('settings')->where('param', '=', "otp")->get()->first()->value,
            'curbsidePickup' => DB::table('settings')->where('param', '=', "curbsidePickup")->get()->first()->value,
            'delivering' => DB::table('settings')->where('param', '=', "delivering")->get()->first()->value,
            'coupon' => DB::table('settings')->where('param', '=', "coupon")->get()->first()->value,
            'deliveringTime' => DB::table('settings')->where('param', '=', "deliveringTime")->get()->first()->value,
            'defaultLat' => DB::table('settings')->where('param', '=', "defaultLat")->get()->first()->value,
            'defaultLng' => DB::table('settings')->where('param', '=', "defaultLng")->get()->first()->value,
        ]);
    }

    public function caLayout_changeTheme(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');
        $mainColor = $request->input('mainColor') ?: "";
        DB::table('settings')->where('param', '=', "mainColor")->update(['value' => "$mainColor", 'updated_at' => new \DateTime(),]);
        $radius = $request->input('radius') ?: "";
        DB::table('settings')->where('param', '=', "radius")->update(['value' => "$radius", 'updated_at' => new \DateTime(),]);
        $shadow = $request->input('shadow') ?: "";
        DB::table('settings')->where('param', '=', "shadow")->update(['value' => "$shadow", 'updated_at' => new \DateTime(),]);
        $dark = $request->input('dark') ?: "";
        DB::table('settings')->where('param', '=', "darkMode")->update(['value' => "$dark", 'updated_at' => new \DateTime(),]);
        $bottomBarType = $request->input('bottomBarType') ?: "type1";
        DB::table('settings')->where('param', '=', "bottomBarType")->update(['value' => "$bottomBarType", 'updated_at' => new \DateTime(),]);
        $appLanguage = $request->input('appLanguage') ?: "";
        DB::table('settings')->where('param', '=', "appLanguage")->update(['value' => "$appLanguage", 'updated_at' => new \DateTime(),]);
        //
        DB::table('docs')->where('param', '=', "about_ca")->update(['value' => $request->input('about'), 'updated_at' => new \DateTime(),]);
        DB::table('docs')->where('param', '=', "delivery_ca")->update(['value' => $request->input('delivery'), 'updated_at' => new \DateTime(),]);
        DB::table('docs')->where('param', '=', "privacy_ca")->update(['value' => $request->input('privacy'), 'updated_at' => new \DateTime(),]);
        DB::table('docs')->where('param', '=', "terms_ca")->update(['value' => $request->input('terms'), 'updated_at' => new \DateTime(),]);
        DB::table('docs')->where('param', '=', "refund_ca")->update(['value' => $request->input('refund'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where('param', '=', "faq_ca")->update(['value' => $request->input('faq'), 'updated_at' => new \DateTime(),]);
        //
        DB::table('settings')->where('param', '=', "googleLogin_ca")->update(['value' => $request->input('google'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where('param', '=', "facebookLogin_ca")->update(['value' => $request->input('facebook'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where('param', '=', "otp")->update(['value' => $request->input('otp'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where('param', '=', "curbsidePickup")->update(['value' => $request->input('curbsidePickup'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where('param', '=', "delivering")->update(['value' => $request->input('delivering'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where('param', '=', "coupon")->update(['value' => $request->input('coupon'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where('param', '=', "deliveringTime")->update(['value' => $request->input('deliveringTime'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where('param', '=', "defaultLat")->update(['value' => $request->input('defaultLat'), 'updated_at' => new \DateTime(),]);
        DB::table('settings')->where('param', '=', "defaultLng")->update(['value' => $request->input('defaultLng'), 'updated_at' => new \DateTime(),]);

        $response = ['error' => "0"];
        return response()->json($response, 200);
    }

    public function caLayoutSizes(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');
        $restaurantCardWidth = DB::table('settings')->where('param', '=', "restaurantCardWidth")->get()->first()->value;
        $restaurantCardHeight = DB::table('settings')->where('param', '=', "restaurantCardHeight")->get()->first()->value;
        $dishesCardHeight = DB::table('settings')->where('param', '=', "dishesCardHeight")->get()->first()->value;
        $oneInLine = DB::table('settings')->where('param', '=', "oneInLine")->get()->first()->value;
        $categoryCardWidth = DB::table('settings')->where('param', '=', "categoryCardWidth")->get()->first()->value;
        $categoryCardHeight = DB::table('settings')->where('param', '=', "categoryCardHeight")->get()->first()->value;
        $categoryCardCircle = DB::table('settings')->where('param', '=', "categoryCardCircle")->get()->first()->value;
        $topRestaurantCardHeight = DB::table('settings')->where('param', '=', "topRestaurantCardHeight")->get()->first()->value;
        $restaurantCardTextSize = DB::table('settings')->where('param', '=', "restaurantCardTextSize")->get()->first()->value;
        $restaurantCardTextColor = DB::table('settings')->where('param', '=', "restaurantCardTextColor")->get()->first()->value;
        $typeFoods = DB::table('settings')->where('param', '=', "typeFoods")->get()->first()->value;

        return view('caLayoutSizes', [
            'restaurantCardWidth' => $restaurantCardWidth,
            'restaurantCardHeight' => $restaurantCardHeight,
            'dishesCardHeight' => $dishesCardHeight,
            'oneInLine' => $oneInLine,
            'categoryCardWidth' => $categoryCardWidth,
            'categoryCardHeight' => $categoryCardHeight,
            'categoryCardCircle' => $categoryCardCircle,
            'topRestaurantCardHeight' => $topRestaurantCardHeight,
            'restaurantCardTextSize' => $restaurantCardTextSize,
            'restaurantCardTextColor' => $restaurantCardTextColor,
            'typeFoods' => $typeFoods,
        ]);
    }

    public function caLayoutSizeChange(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');
        $restaurantCardWidth = $request->input('restaurantCardWidth') ?: "40";
        DB::table('settings')->where('param', '=', "restaurantCardWidth")->update(['value' => "$restaurantCardWidth", 'updated_at' => new \DateTime(),]);
        $restaurantCardHeight = $request->input('restaurantCardHeight') ?: "40";
        DB::table('settings')->where('param', '=', "restaurantCardHeight")->update(['value' => "$restaurantCardHeight", 'updated_at' => new \DateTime(),]);
        $dishesCardHeight = $request->input('dishesCardHeight') ?: "40";
        DB::table('settings')->where('param', '=', "dishesCardHeight")->update(['value' => "$dishesCardHeight", 'updated_at' => new \DateTime(),]);
        $oneInLine = $request->input('oneInLine') ?: "false";
        DB::table('settings')->where('param', '=', "oneInLine")->update(['value' => "$oneInLine", 'updated_at' => new \DateTime(),]);
        $categoryCardHeight = $request->input('categoryCardHeight') ?: "40";
        DB::table('settings')->where('param', '=', "categoryCardHeight")->update(['value' => "$categoryCardHeight", 'updated_at' => new \DateTime(),]);
        $categoryCardWidth = $request->input('categoryCardWidth') ?: "40";
        DB::table('settings')->where('param', '=', "categoryCardWidth")->update(['value' => "$categoryCardWidth", 'updated_at' => new \DateTime(),]);
        $categoryCardCircle = $request->input('categoryCardCircle') ?: "true";
        DB::table('settings')->where('param', '=', "categoryCardCircle")->update(['value' => "$categoryCardCircle", 'updated_at' => new \DateTime(),]);
        $topRestaurantCardHeight = $request->input('topRestaurantCardHeight') ?: "70";
        DB::table('settings')->where('param', '=', "topRestaurantCardHeight")->update(['value' => "$topRestaurantCardHeight", 'updated_at' => new \DateTime(),]);
        $restaurantCardTextSize = $request->input('restaurantCardTextSize') ?: "16";
        DB::table('settings')->where('param', '=', "restaurantCardTextSize")->update(['value' => "$restaurantCardTextSize", 'updated_at' => new \DateTime(),]);
        $restaurantCardTextColor = $request->input('restaurantCardTextColor') ?: "";
        DB::table('settings')->where('param', '=', "restaurantCardTextColor")->update(['value' => "$restaurantCardTextColor", 'updated_at' => new \DateTime(),]);
        $typeFoods = $request->input('typeFoods') ?: "";
        DB::table('settings')->where('param', '=', "typeFoods")->update(['value' => "$typeFoods", 'updated_at' => new \DateTime(),]);

        return response()->json(['error' => "0"], 200);
    }

    public function caSkins(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');
        return view('caSkin', [
            'skin' => DB::table('settings')->where('param', "skin")->get()->first()->value,
        ]);
    }

    public function caSkin_set(Request $request)
    {
        if (!Auth::check())
            return response()->json(['error' => "1"]);
        DB::table('settings')->where('param', "skin")->update(['value' => $request->input('skin'), 'updated_at' => new \DateTime(),]);
        return response()->json(['error' => "0"], 200);
    }

}
