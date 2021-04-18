<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Lang;

// 31.01.2021

class ChatController extends Controller
{
    public function chatUsersApi(Request $request){
        $id = auth('api')->user()->id;
        // get vendor users, all messages from vendor and unread messages
        // and last message from vendor (if exist)
        $users = DB::select("SELECT * FROM (SELECT users.id, users.name, users.role,
            CASE
             WHEN image_uploads.filename IS NULL THEN \"noimage.png\"
             ELSE image_uploads.filename
            END AS image,
            count(chat.read='false' OR chat.read='true') as count,
            (SELECT count(chat.id) FROM chat WHERE chat.read='false' AND chat.from_user=users.id AND chat.to_user=$id) as unread,
            (SELECT chat.text FROM chat WHERE chat.from_user=users.id AND chat.to_user=$id ORDER BY chat.updated_at DESC LIMIT 1) as text
            FROM users
            LEFT JOIN image_uploads ON image_uploads.id=users.imageid
            LEFT JOIN chat ON chat.from_user=users.id AND chat.to_user=$id
            GROUP BY users.id, users.name, image_uploads.filename, users.role
            ORDER BY unread DESC) AS i WHERE (count <> 0 OR role=2) AND id != $id");
        return response()->json([
            'error' => '0',
            'users' => $users,
        ]);
    } // role=2 OR role=1


    public function chatMessages(Request $request)
    {
        $from_user = $request->input('id');
        return ChatController::getMessages($from_user);
    }

    public function getChatMessages(Request $request)
    {
        $from_user = $request->input('user_id');
        return ChatController::getMessages($from_user);
    }

    public function getMessages($from_user){
        $to_user = Auth::id();

        $msg = DB::select("SELECT * FROM (
                (SELECT chat.*, 'customer' as author FROM chat
                WHERE from_user=$from_user AND to_user=$to_user ORDER BY created_at ASC)
                UNION
                (SELECT chat.*, 'vendor' as author FROM chat
                WHERE from_user=$to_user AND to_user=$from_user ORDER BY created_at ASC)) AS i
                ORDER BY created_at ASC
                ");

        $values = array('read' => 'true', 'updated_at' => new \DateTime());
        DB::table('chat')->
            where('from_user', '=', $from_user)->
            where('to_user', '=', $to_user)
            ->update($values);

        $response = [
            'error' => "0",
            'messages' => $msg,
            'unread' => count(DB::table('chat')->where('read', '=', "false")->
                where('to_user', $to_user)->rightJoin("users", "users.id", "chat.from_user")->get()),
        ];
        return response()->json($response, 200);
    }

    public function chat(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');
        return view('chat', []);
    }

    public function chatNewMessage(Request $request){
        $to_user = $request->input('user_id');
        $from_user = Auth::id();
        $text = $request->input('text');
        return ChatController::chatNewMessage2($from_user, $to_user, $text);
    }

    public function chatNewMessageApi(Request $request){
        $to_user = $request->input('id');
        $from_user = auth('api')->user()->id;
        $text = $request->input('text');
        return ChatController::chatNewMessage2($from_user, $to_user, $text);
    }

    public function chatNewMessage2($from_user, $to_user, $text)
    {
        if (!Auth::check())
            return response()->json(['error' => "1",], 200);

        $values = array(
            'to_user' => $to_user,
            'from_user' => $from_user,
            'text' => "$text",
            'delivered' => "false", 'read' => "false",
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        );
        DB::table('chat')->insert($values);

        //
        // Send Notifications to user
        //
        $myRequest = new \Illuminate\Http\Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add(['user' => $to_user]);
        $myRequest->request->add(['chat' => 'true']);
        $myRequest->request->add(['title' => Lang::get(477)]); // Chat Message
        $myRequest->request->add(['text' => $text]);
        $defaultImage = DB::table('settings')->where('param', '=', "notify_image")->get()->first()->value;
        $myRequest->request->add(['imageid' => $defaultImage]);
        MessagingController::sendNotify($myRequest);

        return ChatController::getMessages($to_user);
    }

    public function getChatMessagesNewCount(Request $request)
    {
        if (!Auth::check())
            return response()->json(['error' => "1",], 200);

        $id = Auth::id();
        return response()->json([
            'error' => "0",
            'count' => count(DB::table('chat')->where('read', '=', "false")->
                        where('to_user', $id)->rightJoin("users", "users.id", "chat.from_user")->get()),
            'orders' => count(DB::select("SELECT * FROM orders WHERE vendor=$id AND view='false'")),
        ], 200);
    }

    public function chatNewUsers(Request $request)
    {
        if (!Auth::check())
            return response()->json(['error' => "1",], 200);

        $users = DB::table('users')->where("users.id", '!=', Auth::id())->
            leftjoin("image_uploads", 'image_uploads.id', '=', 'users.imageid')->
            select('users.id', 'users.name', 'image_uploads.filename as image')->get();

        $usersMessages = DB::table('chat')->where('to_user', '=', Auth::id())->
                where('read', '=', "false")->selectRaw('from_user, count(*) as result')->groupBy('from_user')->get();
        $all = DB::table('chat')->where('to_user', '=', Auth::id())->
                selectRaw('from_user, count(*) as result')->groupBy('from_user')->get();

        $usersData = array();
        foreach ($users as &$data) {
            if ($data->image == null)
                $data->image = "noimage.png";
            // all messages
            $data->messages = 0;
            foreach ($all as &$data2){
                if ($data->id == $data2->from_user)
                    $data->messages = $data2->result;
            }
            // unread messages
            $data->unread = 0;
            foreach ($usersMessages as &$data2){
                if ($data->id == $data2->from_user)
                    $data->unread = $data2->result;
            }
            $usersData[] = $data;
        }

        usort($usersData, function($a, $b) {
            if ($a->unread != $b->unread)
                return $a->unread < $b->unread ? 1 : -1;
            if ($a->messages == $b->messages) return 0;
            return $a->messages < $b->messages ? 1 : -1;
        });

        return response()->json([
            'error' => "0",
            'users' => $usersData,
        ], 200);
    }

}
