<?php

namespace App\Http\Controllers\API;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use App\ImageUpload;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function regUser(Request $request)
    {
        $email = $request->input('email');
        $typeReg = ($request->input('typeReg') != null ? $request->input('typeReg') : "email");
        $user = DB::table('users')->where('email', "=", $email)->get()->first();
        if ($user != null && $typeReg == "email")
            return response(['error' => '3']);  // This email is busy
        if ($user != null)
            return AuthController::login($request);

        $validatedData['email'] = $request->input('email');
        $validatedData['typeReg'] = $typeReg;
        $validatedData['name'] = $request->input('name');
        $validatedData['password'] = bcrypt($request->password);
        $validatedData['role'] = 4;
        if ($request->input('role') != null)
            $validatedData['role'] = $request->input('role');

        $user = User::create($validatedData);
        $accessToken = $user->createToken('authToken')->accessToken;

        $photoUrl = $request->input('photoUrl');
        if ($photoUrl != "") {
            $image = file_get_contents($photoUrl);
            $uuid = Str::uuid()->toString();
            $avatar = "$uuid.jpg";
            file_put_contents(public_path("images/$avatar"), $image);
            //
            $imageUpload = new ImageUpload();
            $imageUpload->filename = $avatar;
            $imageUpload->save();

            $id = $user->id;
            DB::table('users')->where('id', "=", $id)
                ->update(array('imageid' => $imageUpload->id, 'updated_at' => new \DateTime()));
            $user['avatar'] = $avatar;
        }else{
            // user avatar
            $petani = DB::table('image_uploads')->get();
            $user['avatar'] = "noimage.png";
            foreach ($petani as &$value2)
                if ($user->imageid == $value2->id)
                    $user['avatar'] = $value2->filename;
        }

        return response(['error' => '0', 'user' => $user, 'access_token' => $accessToken]);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['error' => 1, 'message' => 'Invalid Credentials', 'appType' => "multivendor"]);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        $user = auth()->user();

        //
        // for driver app
        //
        $driver = $request->input('driver') ?: "";
        if ($driver == 'true'){
            if ($user->role != 3)
                return response(['error' => 2, 'message' => 'No driver']);
        }

        //
        // for owner app
        //
        $owner = $request->input('owner') ?: "";
        if ($owner == 'true'){
            if ($user->role != 2)       // only vendors
                return response(['error' => 2, 'message' => 'Not vendor', 'appType' => "multivendor"]);
        }

        // user avatar
        $petani = DB::table('image_uploads')->get();
        $user['avatar'] = "noimage.png";
        foreach ($petani as &$value2)
            if ($user->imageid == $value2->id)
                $user['avatar'] = $value2->filename;

        $id = auth()->user()->id;
        $notify2 = DB::table('notifications')->where('user', '=', "$id")->where('delete', '=', "0")->where('read', '=', "0")->get();
        $notify = count($notify2);
        return response(['error' => 0, 'user' => $user, 'access_token' => $accessToken, 'notify' => $notify, 'appType' => "multivendor"]);

    }

    public function uploadAvatar(Request $request)
    {
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('images'), $imageName);

        $imageUpload = new ImageUpload();
        $imageUpload->filename = $imageName;
        $imageUpload->save();

        $id = auth('api')->user()->id;
        DB::table('users')->where('id', "=", $id)
            ->update(array('imageid' => $imageUpload->id, 'updated_at' => new \DateTime()));

        return response()->json(['ret'=>true, 'avatar' => $imageName]);
    }

    public function forgot(Request $request)
    {
        $error = '0';
        $email = $request->input('email');

        $user = DB::table('users')->where('email', "=", $email)->get()->first();
        if ($user == null)
            return response(['error' => '5000']);   // user not found

        $recipient = $email;

        $sender = 'sender@valeraletun.ru';
        $subject = "Password recovery";

        $pass = AuthController::rand_passwd();
        $message = '<html><body>';
        $message .= '<h1>Hello!</h1>';
        $message .= '<p>You received this email because you requested a password recovery in the FoodDelivery mobile app.</p>';
        $message .= '<p>Your new password: ' . $pass . ' </p>';
        $message .= '</body></html>';

        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        // Create email headers
        $headers .= 'From: '.$sender."\r\n".
            'Reply-To: '.$sender."\r\n" .
            'X-Mailer: PHP/' . phpversion();

        if (mail($recipient, $subject, $message, $headers))
        {
            $encpass = bcrypt($pass);
            $values = array('password' => $encpass,
                'updated_at' => new \DateTime());
            DB::table('users')
                ->where('email', $email)
                ->update($values);
        }
        else
            $error = '5001'; // cant send email

        return response(['error' => $error]);
    }

    function rand_passwd( $length = 8, $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789' ) {
        return substr( str_shuffle( $chars ), 0, $length );
    }

    public function fcbToken(Request $request){
        $fcbToken = $request->input('fcbToken');
        $id = auth('api')->user()->id;
        $values = array('fcbToken' => $fcbToken,
            'updated_at' => new \DateTime());
        DB::table('users')
            ->where('id', $id)
            ->update($values);
        return response(['error' => '0']);
    }

    public function changePassword(Request $request){
        $oldPassword = $request->input('oldPassword') ?: "";
        $newPassword = $request->input('newPassword') ?: "";
        $id = auth('api')->user()->id;
        $user = DB::table('users')->where('id', $id)->get()->first();
        $pass = auth('api')->user()->password;
        if (!Hash::check($oldPassword, $pass))
            return response(['error' => '1']);
        if (strlen($newPassword) < 6)
            return response(['error' => '2']);
        $values = array('password' => bcrypt($newPassword),
            'updated_at' => new \DateTime());
        auth('api')->user()->password = bcrypt($newPassword);
        auth('api')->user()->save();
        DB::table('users')
            ->where('id', $id)
            ->update($values);
        return response(['error' => '0']);
    }

    public function changeProfile(Request $request){
        $name = $request->input('name') ?: "";
        $email = $request->input('email') ?: "";
        $phone = $request->input('phone') ?: "";
        $id = auth('api')->user()->id;
        $values = array('name' => $name, 'email' => $email, 'phone' => $phone,
            'updated_at' => new \DateTime());
        auth('api')->user()->phone = $phone;
        auth('api')->user()->email = $email;
        auth('api')->user()->name = $name;
        auth('api')->user()->save();
        return response(['error' => '0']);
    }


}
