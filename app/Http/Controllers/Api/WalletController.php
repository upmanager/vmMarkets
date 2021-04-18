<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function walletGetBalans(Request $request)
    {
        $id = auth('api')->user()->id;

        $balance = DB::table('wallet')->where('user', '=', $id)->get()->first();
        if ($balance != null)
            $balance = $balance->balans;
        else
            $balance = 0;

        $response = [
            'error' => 0,
            'balance' => "$balance",
        ];
        return response()->json($response, 200);
    }

    public function walletTopUp(Request $request)
    {
        $id = auth('api')->user()->id;

        $total = $request->input('total');
        $payment = $request->input('id');

        $balance = DB::table('wallet')->where('user', '=', $id)->get()->first();
        if ($balance != null)
            $balance = $balance->balans;
        else
            $balance = 0;
        //
        $balance += $total;

        $values = array('balans' => $balance, 'updated_at' => new \DateTime());
        if (count(DB::table('wallet')->where('user', '=', $id)->get()) == 0){
            $values['created_at'] = new \DateTime();
            $values['user'] = $id;
            DB::table('wallet')->insert($values);
        }else{
            DB::table('wallet')->where('user', '=', $id)->update($values);
        }
        // log
        $values = array(
            'amount' => $total,
            'total' => $balance,
            'user' => $id,
            'arrival' => true,
            'comment' => "$payment",
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

    public function payOnWallet(Request $request)
    {
        $id = auth('api')->user()->id;

        $total = $request->input('total');

        $balance = DB::table('wallet')->where('user', '=', $id)->get()->first();
        if ($balance != null)
            $balance = $balance->balans;
        else
            $balance = 0;
        //
        if ($balance < $total) {
            $response = [
                'error' => 1,
                'msg' => "There are not enough funds in the account",
            ];
            return response()->json($response, 200);
        }
        $balance -= $total;

        $values = array('balans' => $balance, 'updated_at' => new \DateTime());
        if (count(DB::table('wallet')->where('user', '=', $id)->get()) == 0){
            $values['created_at'] = new \DateTime();
            $values['user'] = $id;
            DB::table('wallet')->insert($values);
        }else{
            DB::table('wallet')->where('user', '=', $id)->update($values);
        }

        // log
        $values = array(
            'amount' => $total,
            'total' => $balance,
            'user' => $id,
            'arrival' => false,
            'comment' => "Payment id #not set",
            'updated_at' => new \DateTime(),
            'created_at' => new \DateTime(),
        );
        DB::table('walletlog')->insert($values);
        $lastId = DB::getPdo()->lastInsertId();

        $response = [
            'error' => 0,
            'balance' => "$balance",
            'id' => $lastId,
        ];
        return response()->json($response, 200);
    }

    public function walletSetId(Request $request)
    {
        $id = auth('api')->user()->id;

        $walletId = $request->input('walletId');
        $orderId = $request->input('orderId');

        $values = array('comment' => "Payment id #" . $orderId, 'updated_at' => new \DateTime());
        DB::table('walletlog')->where('id', '=', $walletId)->update($values);

        $response = [
            'error' => 0,
            'values' => $values,

        ];
        return response()->json($response, 200);
    }
}


