<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

// 31.01.2021

class WalletController extends Controller
{
    public function wallet(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        $users = DB::table('users')->where("role", "4")->get();
        foreach ($users as &$value) {
            $t = DB::table('wallet')->where("user", $value->id)->get()->first();
            if ($t != null)
                $value->balance = $t->balans;
            else
                $value->balance = 0;
            $image = DB::table('image_uploads')->where("id", $value->imageid)->get()->first();
            if ($image == null)
                $value->image = "img/user.png";
            else
                $value->image = "images/" . $image->filename;
        }

        return view('wallet', ['users' => $users]);
    }

    public function walletDetails(Request $request)
    {
        if (!Auth::check())
            return response()->json(['error' => "1"]);

        $walletId = $request->input('walletId');
        $walletlog = DB::table('walletlog')->where('user', '=', $walletId)->orderBy('walletlog.updated_at', 'desc')->get();

        $response = [
            'error' => 0,
            'walletlog' => $walletlog,
        ];
        return response()->json($response, 200);

    }

    public function walletChangeBalans(Request $request)
    {
        if (!Auth::check())
            return response()->json(['error' => "1"]);

        $balance = $request->input('balance');
        $comments = $request->input('comments');
        $id = $request->input('id');

        $cBalance = DB::table('wallet')->where('user', '=', $id)->get()->first();
        if ($cBalance != null)
            $cBalance = $cBalance->balans;
        else
            $cBalance = 0;
        //
        $arrival = true;
        if ($balance > $cBalance) {
            $cBalance = $balance - $cBalance;
        }else {
            $arrival = false;
            $cBalance = $cBalance - $balance;
        }

        $values = array('balans' => $balance, 'updated_at' => new \DateTime());
        if (count(DB::table('wallet')->where('user', '=', $id)->get()) == 0){
            $values['created_at'] = new \DateTime();
            $values['user'] = $id;
            DB::table('wallet')->insert($values);
        }else{
            DB::table('wallet')->where('user', '=', $id)->update($values);
        }
        // log
        $editorId = Auth::user()->id;
        $managerName = DB::table('users')->where('id', '=', $editorId)->get()->first()->name;

        $values = array(
            'amount' => $cBalance,
            'total' => $balance,
            'user' => $id,
            'arrival' => $arrival,
            'comment' => "Change by manager:" . $managerName . ". Comment: " . $comments,
            'updated_at' => new \DateTime(),
            'created_at' => new \DateTime(),
        );
        DB::table('walletlog')->insert($values);

        $response = [
            'error' => 0,
            'balance' => "$balance",
        ];
        return response()->json($response, 200);
    }

}
