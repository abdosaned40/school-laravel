<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\AuthMail;
use App\Mail\VerifyMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class UserControlController extends Controller
{
    function index()
    {
        $data = User::all();
        return view('user_control.index', ['uc' => $data]);
    }

    function tambah()
    {
        return view('user_control.tambah');
    }
    function create(Request $request)
    {
        $str = Str::random(100);
        $image = '';

        $request->validate([
            'fullname' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'fullname.required' => 'Full Name Wajib Di isi',
            'fullname.min' => 'Bidang Full Name minimal harus 4 karakter.',
            'email.required' => 'Email Wajib Di isi',
            'email.email' => 'Format Email Invalid',
            'password.required' => 'Password Wajib Di isi',
            'password.min' => 'Password minimal harus 6 karakter.',
        ]);


        if ($request->hasFile('image')) {

            $request->validate(['image' => 'mimes:jpeg,jpg,png,gif|image|file|max:1024']);

            $image_file = $request->file('image');
            $foto_ekstensi = $image_file->extension();
            $nama_foto = date('ymdhis') . "." . $foto_ekstensi;
            $image_file->move(public_path('picture/accounts'), $nama_foto);
            $image = $nama_foto;
        } else {
            $image = "user.jpeg";
        }

        $accounts = User::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => $request->password,
            'verify_key' => $str,
            'image' => $image,
        ]);

        $details = [
            'nama' => $accounts->fullname,
            'role' => 'user',
            'datetime' => date('Y-m-d H:i:s'),
            'website' => 'Abdo Sanad',
            'url' => 'http://' . request()->getHttpHost() . "/" . "verify/" . $accounts->verify_key,
        ];

        // Mail::to($request->email)->send(new AuthMail($details));
        Mail::to($request->email['email'])->send(new VerifyMail($details));

        Session::flash('success', 'User successfully added, please verify account before use.');

        return redirect('/usercontrol');
    }

    function edit($id)
    {
        $data = User::where('id', $id)->get();
        return view('user_control.edit', ['uc' => $data]);
    }
    function change(Request $request)
    {
        $request->validate([
            'image' => 'image|file|max:1024',
            'fullname' => 'required|min:4',
        ], [
            'image.image' => 'Feel and answer image',
            'image.file' => 'Mandatory File',
            'image.max' => 'The image field cannot be larger than 1024 kilobytes',
            'fullname.required' => 'Name is required',
            'fullname.min' => 'The name field must be at least 4 characters long.',
        ]);



        $user = User::find($request->id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $foto_ekstensi = $image->extension();
            $nama_foto = date('ymdhis') . "." . $foto_ekstensi;
            $image->move(public_path('image'), $nama_foto);
            $user->image = $nama_foto;
        }

        $user->fullname = $request->fullname;
        $user->password = $request->password;
        $user->save();

        Session::flash('success', 'User edited successfully');

        return redirect('/usercontrol');
    }
    function deleta(Request $request)
    {
        User::where('id', $request->id)->delete();

        Session::flash('success', 'Data deleted successfully');

        return redirect('/usercontrol');
    }
}

