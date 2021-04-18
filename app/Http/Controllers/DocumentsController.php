<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Lang;

class DocumentsController extends Controller
{
    public function load(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        return view('documents', []);
    }

    public function save(Request $request)
    {
        if (!Auth::check())
            return response()->json(['error'=>"1"]);

        DB::table('docs')->where('param', 'copyright_text')->update(array('value' => $request->input('copyright'), 'updated_at' => new \DateTime()));
        DB::table('docs')->where('param', 'about_text_name')->update(array('value' => $request->input('about'), 'updated_at' => new \DateTime()));
        DB::table('docs')->where('param', 'terms_text_name')->update(array('value' => $request->input('terms'), 'updated_at' => new \DateTime()));
        DB::table('docs')->where('param', 'privacy_text_name')->update(array('value' => $request->input('policy'), 'updated_at' => new \DateTime()));
        DB::table('docs')->where('param', 'delivery_text_name')->update(array('value' => $request->input('delivery'), 'updated_at' => new \DateTime()));
        DB::table('docs')->where('param', 'refund_text_name')->update(array('value' => $request->input('refund'), 'updated_at' => new \DateTime()));
        //
        DB::table('docs')->where('param', 'about_text')->update(array('value' => $request->input('about_text'), 'updated_at' => new \DateTime()));
        DB::table('docs')->where('param', 'terms_text')->update(array('value' => $request->input('terms_text'), 'updated_at' => new \DateTime()));
        DB::table('docs')->where('param', 'privacy_text')->update(array('value' => $request->input('privacy_text'), 'updated_at' => new \DateTime()));
        DB::table('docs')->where('param', 'delivery_text')->update(array('value' => $request->input('delivery_text'), 'updated_at' => new \DateTime()));
        DB::table('docs')->where('param', 'refund_text')->update(array('value' => $request->input('refund_text'), 'updated_at' => new \DateTime()));

        return response()->json(['error'=>"0"]);
    }

}
