<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\AuthMail;
use App\Mail\VerifyMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
   function index(){
    return view('halaman_auth/login');
   }
   function login(Request $request){
    $request->validate([
        'email' => 'required',
        'password' => 'required',

    ],[
        'email.required' => 'Email is required ',
        'password.required' => 'Password is required ',
    ]);
      $infologin =[
      'email' => $request->email,
      'password' => $request->password,
      ];

      if (Auth::attempt($infologin)) {
        if(Auth::user()->email_verified_at != null){
             if(Auth::user()->role === 'admin'){
                return redirect()->route('admin')->with('success', 'Hello Admin , You have successfully logged in');
             }else if(Auth::user()->role === 'user'){
                return redirect()->route('user')->with('success', 'Hello user , You have successfully logged in');
             }


            return redirect()->route('auth')->withErrors('Your account is not active yet. Please verify first');
        }


      }
        return redirect()->route('auth')->withErrors('Incorrect email or password');
      }


   function create(){
    return view('halaman_auth.register');
   }
   function register(Request $request){
    $str = Str::random(100);
    $request->validate([
             'fullname' => 'required|min:5',
             'email' => 'required|unique:users|email',
             'password' => 'required|min:6',
             'image' => 'required|file',
    ],[
        'fullname.required' => 'Fullname is required',
        'fullname.min' => 'Fullname min 5 ',
        'email.required' => 'email is required',
        'email.unique' => 'email  f',
        'password.required' => 'password is required',
        'password.min' => 'password min 5 ',
        'image.required' => 'Image is required',
        'image.image' => 'Image is uplode',
        'image.file' => 'Image is file',

    ]);

         $image_file = $request->file('image');
         $image_extension =$image_file->extension();
         $name_image = date('ymdhis') . "." . $image_extension;
         $image_file->move(public_path('picture/accounts'),$name_image);

         $inforegister = [
           'fullname' => $request->fullname,
           'email' => $request->email,
           'password' => $request->password,
           'image' => $name_image,
           'verify_key' => $str
      ];


      User::create($inforegister);

      $details = [
        'name'=>$inforegister['fullname'],
        'role'=> 'user',
        'datetime' => date('Y-m-d H:i:s'),
        'website'=> 'AbdoSaned',
        'url'=>'http://'. request()->getHttpHost() . "/" ."verify/". $inforegister['verify_key'],
      ];
    //   Mail::to($inforegister['email'])->send(new AuthMail($details));
    Mail::to($inforegister['email'])->send(new VerifyMail($details));

      return redirect()->route('auth')->with('success', 'A verification link has been sent to your email. Check your email to verify ');
    }
    function verify($verfy_key){
        $keyCheck = User::select('verify_key')
        ->where('verify_key', $verfy_key)
        ->exists();


        if($keyCheck){
            $user = User::where('verify_key',$verfy_key)->update(['email_verified_at' => date('Y-m-d H:i:s')]);

            return redirect()->route('auth')->with('success','success verification');

        }else{
            return redirect()->route('auth')->withErrors('Keys are invalid. Make sure you have registered')->withInput();
        }
    }
        function logout(){
            Auth::logout();
            return redirect('/');
        }
}
