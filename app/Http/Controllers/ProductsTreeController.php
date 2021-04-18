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

class ProductsTreeController extends Controller
{
    public function load(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        return view('productsTree', []);
    }
}

