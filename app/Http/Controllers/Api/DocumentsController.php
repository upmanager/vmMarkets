<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\DB;

class DocumentsController extends Controller
{
    public function getDocuments(Request $request)
    {
        $doc = $request->input('doc');

        $text = DB::table('docs')->where('param', '=', $doc . "_text")->get()->first();
        if ($text != null)
            return response()->json([
                'error' => '0',
                'doc' => $text->value,
            ], 200);

        return response()->json([
            'error' => '1',
        ], 200);
    }

}
