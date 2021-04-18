<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use App\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Lang;

class SettingsController extends Controller
{
    public function load(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        $tax = DB::table('settings')->where('param', '=', "default_tax")->get()->first()->value;
        $firebase = DB::table('settings')->where('param', '=', "firebase_key")->get()->first()->value;
        $mapapikey = DB::table('settings')->where('param', '=', "mapapikey")->get()->first()->value;
        $distanceUnit = DB::table('settings')->where('param', '=', "distanceUnit")->get()->first()->value;

        // time zone
        $timezonesArray = timezone_identifiers_list();
        $timezone = DB::table('settings')->where('param', '=', "timezone")->get()->first()->value;

        return view('settings', ['tax' => $tax, 'firebase' => $firebase, 'mapapikey' => $mapapikey,
            'distanceUnit' => $distanceUnit, 'timezonesArray' => $timezonesArray, 'timezone' => $timezone]);
    }

    public function settingsSetLang(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        $newLang = $request->input('newLang') ?: 'langEng';
        Lang::setNewLang($newLang);

        return \Redirect::to('/apSettings');
    }

    public function change(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        $tax = $request->input('tax') ?: 0;
        DB::table('settings')->where('param', 'default_tax')->update(array('value' => $tax, 'updated_at' => new \DateTime()));
        $distanceUnit = $request->input('distanceUnit');
        DB::table('settings')->where('param', 'distanceUnit')->update(array('value' => $distanceUnit, 'updated_at' => new \DateTime()));

        $firebase = $request->input('firebase') ?: "";
        DB::table('settings')->where('param', 'firebase_key')->update(array('value' => $firebase, 'updated_at' => new \DateTime()));
        $mapapikey = $request->input('mapapikey') ?: "";
        DB::table('settings')->where('param', 'mapapikey')->update(array('value' => $mapapikey, 'updated_at' => new \DateTime()));

        DB::table('settings')->where('param', 'timezone')->update(array('value' => $request->input('timezone'), 'updated_at' => new \DateTime()));

        $response = ['error' => "0"];
        return response()->json($response, 200);
    }

    //
    //
    //
    public function payments(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        return SettingsController::paymentsView("", "");
    }

    function paymentsView($green, $text){
        $StripeEnable = DB::table('settings')->where('param', '=', "StripeEnable")->get()->first()->value;
        $stripeKey = DB::table('settings')->where('param', '=', "stripeKey")->get()->first()->value;
        $stripeSecretKey = DB::table('settings')->where('param', '=', "stripeSecretKey")->get()->first()->value;
        $razEnable = DB::table('settings')->where('param', '=', "razEnable")->get()->first()->value;
        $razKey = DB::table('settings')->where('param', '=', "razKey")->get()->first()->value;
        $razName = DB::table('settings')->where('param', '=', "razName")->get()->first()->value;
        $cashEnable = DB::table('settings')->where('param', '=', "cashEnable")->get()->first()->value;
        //
        $walletEnable = DB::table('settings')->where('param', '=', "walletEnable")->get()->first()->value;
        $payPalEnable = DB::table('settings')->where('param', '=', "payPalEnable")->get()->first()->value;
        $payPalSandBox = DB::table('settings')->where('param', '=', "payPalSandBox")->get()->first()->value;
        $payPalClientId = DB::table('settings')->where('param', '=', "payPalClientId")->get()->first()->value;
        $payPalSecret = DB::table('settings')->where('param', '=', "payPalSecret")->get()->first()->value;
        $payStackKey = DB::table('settings')->where('param', '=', "payStackKey")->get()->first()->value;
        $payStackKey = DB::table('settings')->where('param', '=', "payStackKey")->get()->first()->value;
        $payStackEnable = DB::table('settings')->where('param', '=', "payStackEnable")->get()->first()->value;
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

        return view('payments', ['StripeEnable' => $StripeEnable, 'stripeKey' => $stripeKey, 'stripeSecretKey' => $stripeSecretKey,
            'razEnable' => $razEnable, 'razKey' => $razKey, 'razName' => $razName, 'cashEnable' => $cashEnable,
            'payPalEnable' => $payPalEnable, 'payPalSandBox' => $payPalSandBox, 'payPalClientId' => $payPalClientId, 'payPalSecret' => $payPalSecret,
            'walletEnable' => $walletEnable,
            'payStackEnable' => $payStackEnable, 'payStackKey' => $payStackKey,
            'yandexKassaEnable' => $yandexKassaEnable, 'yandexKassaShopId' => $yandexKassaShopId,
            'yandexKassaClientAppKey' => $yandexKassaClientAppKey, 'yandexKassaSecretKey' => $yandexKassaSecretKey,
            'instamojoEnable' => $instamojoEnable, 'instamojoSandBoxMode' => $instamojoSandBoxMode,
            'instamojoApiKey' => $instamojoApiKey, 'instamojoPrivateToken' => $instamojoPrivateToken
            ]);
    }

    public function paymentsSave(Request $request){
        $StripeEnable = $request->input('StripeEnable') ?: "";
        $stripeKey = $request->input('stripeKey') ?: "";
        $stripeSecretKey = $request->input('stripeSecretKey') ?: "";
        $razEnable = $request->input('razEnable') ?: "";
        $razKey = $request->input('razKey') ?: "";
        $razName = $request->input('razName') ?: "";
        $cashEnable = $request->input('cashEnable') ?: "";
        $walletEnable = $request->input('walletEnable') ?: "";
        DB::table('settings')->where('param', 'StripeEnable')->update(array('value' => $StripeEnable, 'updated_at' => new \DateTime()));
        DB::table('settings')->where('param', 'stripeKey')->update(array('value' => $stripeKey, 'updated_at' => new \DateTime()));
        DB::table('settings')->where('param', 'stripeSecretKey')->update(array('value' => $stripeSecretKey, 'updated_at' => new \DateTime()));
        DB::table('settings')->where('param', 'razEnable')->update(array('value' => $razEnable, 'updated_at' => new \DateTime()));
        DB::table('settings')->where('param', 'razKey')->update(array('value' => $razKey, 'updated_at' => new \DateTime()));
        DB::table('settings')->where('param', 'razName')->update(array('value' => $razName, 'updated_at' => new \DateTime()));
        DB::table('settings')->where('param', 'cashEnable')->update(array('value' => $cashEnable, 'updated_at' => new \DateTime()));
        DB::table('settings')->where('param', 'walletEnable')->update(array('value' => $walletEnable, 'updated_at' => new \DateTime()));
        // PayPal
        $payPalEnable = $request->input('payPalEnable') ?: "";
        DB::table('settings')->where('param', 'payPalEnable')->update(array('value' => $payPalEnable, 'updated_at' => new \DateTime()));
        $payPalSandBox = $request->input('payPalSandBox') ?: "";
        DB::table('settings')->where('param', 'payPalSandBox')->update(array('value' => $payPalSandBox, 'updated_at' => new \DateTime()));
        $payPalClientId = $request->input('payPalClientId') ?: "";
        DB::table('settings')->where('param', 'payPalClientId')->update(array('value' => $payPalClientId, 'updated_at' => new \DateTime()));
        $payPalSecret = $request->input('payPalSecret') ?: "";
        DB::table('settings')->where('param', 'payPalSecret')->update(array('value' => $payPalSecret, 'updated_at' => new \DateTime()));
        // PayStack
        $payStackEnable = $request->input('payStackEnable') ?: "";
        DB::table('settings')->where('param', 'payStackEnable')->update(array('value' => $payStackEnable, 'updated_at' => new \DateTime()));
        $payStackKey = $request->input('payStackKey') ?: "";
        DB::table('settings')->where('param', 'payStackKey')->update(array('value' => $payStackKey, 'updated_at' => new \DateTime()));
        // yandexKassa
        DB::table('settings')->where('param', 'yandexKassaEnable')->update(array('value' => $request->input('yandexKassaEnable') ?: "", 'updated_at' => new \DateTime()));
        DB::table('settings')->where('param', 'yandexKassaShopId')->update(array('value' => $request->input('yandexKassaShopId') ?: "", 'updated_at' => new \DateTime()));
        DB::table('settings')->where('param', 'yandexKassaClientAppKey')->update(array('value' => $request->input('yandexKassaClientAppKey') ?: "", 'updated_at' => new \DateTime()));
        DB::table('settings')->where('param', 'yandexKassaSecretKey')->update(array('value' => $request->input('yandexKassaSecretKey') ?: "", 'updated_at' => new \DateTime()));
        // instamojo
        DB::table('settings')->where('param', 'instamojoEnable')->update(array('value' => $request->input('instamojoEnable') ?: "", 'updated_at' => new \DateTime()));
        DB::table('settings')->where('param', 'instamojoSandBoxMode')->update(array('value' => $request->input('instamojoSandBoxMode') ?: "", 'updated_at' => new \DateTime()));
        DB::table('settings')->where('param', 'instamojoApiKey')->update(array('value' => $request->input('instamojoApiKey') ?: "", 'updated_at' => new \DateTime()));
        DB::table('settings')->where('param', 'instamojoPrivateToken')->update(array('value' => $request->input('instamojoPrivateToken') ?: "", 'updated_at' => new \DateTime()));

        return response()->json(['ret'=>0, 'text' => Lang::get(466)]); // "Payments Methods Saved"
    }

    public function currencies(Request $request){
        if (!Auth::check())
            return \Redirect::route('/');
        $default_currencyCode = DB::table('settings')->where('param', '=', "default_currencyCode")->get()->first()->value;
        $currencies = DB::table('currencies')->get();
        $rightSymbol = DB::table('settings')->where('param', '=', "rightSymbol")->get()->first()->value;
        return view('currencies', ['currencies' => $currencies, 'default_currencyCode' => $default_currencyCode, 'rightSymbol' => $rightSymbol]);
    }

    public function currencyadd(Request $request){
        $name = $request->input('name') ?: "";
        $code = $request->input('code') ?: "";
        $symbol = $request->input('symbol') ?: "";
        $digits = $request->input('digits') ?: 2;

        $values = array('name' => $name, 'code' => $code, 'symbol' => $symbol, 'digits' => $digits, 'created_at' => new \DateTime(), 'updated_at' => new \DateTime());
        DB::table('currencies')->insert($values);
        return \Redirect::to('/currencies');
    }

    public function currencydelete(Request $request){
        if (!Auth::check())
            return \Redirect::route('/');

        $id = $request->input('id');
        if (Settings::isDemoMode())
            return response()->json(['ret'=>false, 'text'=>Lang::get(467)]); // 'This is demo app. You can\'t change this section'
        DB::table('currencies')->where('id',$id)->delete();

        return response()->json(['ret'=>true]);

    }

    public function currencyedit(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        $id = $request->input('editid') ?: 0;
        $name = $request->input('name') ?: "";
        $code = $request->input('code') ?: "";
        $symbol = $request->input('symbol') ?: "";
        $digits = $request->input('digits') ?: 0;

        $values = array('name' => $name, 'code' => $code, 'symbol' => $symbol, 'digits' => $digits, 'updated_at' => new \DateTime());

        DB::table('currencies')
            ->where('id',$id)
            ->update($values);

        return \Redirect::to('/currencies');
    }

    public function currencyChange(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        $id = $request->input('currency') ?: 0;
        $code = DB::table('currencies')->where('id',$id)->get()->first()->code;
        $symbol = DB::table('currencies')->where('id',$id)->get()->first()->symbol;

        DB::table('settings')->where('param', '=', "default_currencyCode")->update(array('value' => $code, 'updated_at' => new \DateTime()));
        DB::table('settings')->where('param', '=', "default_currencies")->update(array('value' => $symbol, 'updated_at' => new \DateTime()));

        return \Redirect::to('/currencies');
    }

    public function setRightSymbol(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        $value = $request->input('value') ?: "";
        if ($value != "true")
            $value = "false";

        DB::table('settings')->where('param', '=', "rightSymbol")->update(array('value' => $value, 'updated_at' => new \DateTime()));

        return \Redirect::to('/currencies');
    }


}
