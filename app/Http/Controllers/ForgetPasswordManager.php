<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgetPasswordManager extends Controller
{
    function forgetPassword(){
        return view("forget-password");
    }
    function forgetPasswordPost(Request $request){
        $request->validate([
            'email' => "required|email|exists:users",
        ]);
          $token = Str::random(length:64);

          DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
          ]);

          Mail::send( "emails.forget-password", ['token' => $token], function ($message) use ($request){
            $message->to($request->email);
            $message->subject("Reset Password");
          });

// Mail::send([ 'emails.forget-password'], ['token' => $token], function ($message) use ($request) {
//     $message->to($request->email)
//         ->subject("Reset Password");
// });


         return redirect()->to(route("forget.password"))->with("success", "we have send an email to reset password");



    }

    function reswtPassword($token){
       return view("new-password", compact('token'));
    }

    function resetPasswordPost(Request $request){
        $request->validate([
         'email' => "required|email|exists:users",
         'password' => "required|string|min:6|confirmed",
         'password_confirmation' => "required"
        ]);

        $updatePassword = DB::table('password_reset_tokens')->where([
            "email" => $request->email,
            "token" => $request->token
        ])->first();

        if (!$updatePassword){
            return redirect()->to(route("reset.password"))->wiht("error", "Inviled");
        }
        User::where("email", $request->email)->update(["password" => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where(["email" => $request->email])->delete();

        return redirect()->to(route("login"))->with("success", "Password reset success");
    }


}
