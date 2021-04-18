<?php

namespace App\Http\Controllers;

use App\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\UserInfo;

class MarketsReviewsController extends Controller
{
    public function load(Request $request){
        if (!Auth::check())
            return \Redirect::route('/');

        return view('marketsReview', []);
    }
}
