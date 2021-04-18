<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\DB;

class BaseController extends Controller
{
    public function getFaq(Request $request)
    {
        $faq = DB::table('faq')->where('published', "=", '1')->get();
        $response = [
            'success' => true,
            'data'=> $faq,
        ];
        return response()->json($response, 200);
    }

}
