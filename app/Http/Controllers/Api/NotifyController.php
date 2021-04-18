<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\DB;

class NotifyController extends Controller
{
    public function get(Request $request)
    {
        $id = auth('api')->user()->id;

        $notify = DB::table('notifications')->
        leftjoin("image_uploads", 'image_uploads.id', '=', 'notifications.image')->
        where('notifications.user', '=', "$id")->where('notifications.delete', '=', "0")->
        select('notifications.*', 'image_uploads.filename as image')->orderBy('notifications.updated_at', 'desc')->get();

        foreach ($notify as &$value) {
            if ($value->image == "")
                $value->image = "noimage.png";
        }

        $values = array('read' => 1);
        DB::table('notifications')->where('user', '=', "$id")->update($values);

        $response = [
            'error' => '0',
            'notify' => $notify,
        ];
        return response()->json($response, 200);
    }

    public function delete(Request $request)
    {
        $userid = auth('api')->user()->id;
        $id = $request->input('id');

        $values = array(
            'delete' => 1,
            'updated_at' => new \DateTime());

        DB::table('notifications')
            ->where('id',$id)->where('user',$userid)
            ->update($values);

        $response = [
            'error' => '0',
        ];
        return response()->json($response, 200);
    }
}
