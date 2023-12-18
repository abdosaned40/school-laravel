<?php

use App\Http\Controllers\DataStudent;
use App\Http\Controllers\ForgetPasswordManager;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UproleController;
use App\Http\Controllers\UserControlController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/',function(){
//     return view('halaman_depan.index');
// });

Route::middleware(['guest'])->group(function(){
    //   Route::get('/', 'halaman_depan.index');
    Route::get('/',function(){
    return view('halaman_depan.index');
});
    Route::get('/sesi',[AuthController::class,'index'])->name('auth');
    Route::post('/sesi',[AuthController::class,'login'])->name('login');
    // Route::get('/sesi', 'AuthController@login')->name('sesi');
    Route::get('/reg',[AuthController::class,'create'])->name('registerasi');
    Route::post('/reg',[AuthController::class,'register']);
    Route::get('/verify/{verfy_key}',[AuthController::class, 'verify'] );
});



Route::middleware(['auth'])->group(function(){
    Route::redirect('/home', '/user');
    Route::get('/admin',[AdminController::class, 'index'])->name('admin')->middleware('userAkses:admin');
    Route::get('/user',[UserController::class, 'index'])->name('user')->middleware('userAkses:user');

    Route::get('/datastudent',[DataStudent::class, 'index'])->name('datastudent');
     Route::get('/damatambah',[DataStudent::class, 'tambah']);
    Route::get('/damaedit/{id}', [DataStudent::class, 'edit']);
    Route::post('/damadeleta/{id}', [DataStudent::class, 'deleta']);
    Route::get('/usercontrol',[UserControlController::class, 'index'])->name('usercontrol');

    Route::post('/logout',[AuthController::class, 'logout'])->name('logout');


        Route::post('/tambahdama', [DataStudent::class, 'create']);
        Route::post('/editdama', [DataStudent::class, 'change']);

        Route::get('/tambahuc', [UserControlController::class, 'tambah']);
        Route::get('/edituc/{id}', [UserControlController::class, 'edit']);
        Route::post('/deletauc/{id}', [UserControlController::class, 'deleta']);
        Route::post('/tambahuc', [UserControlController::class, 'create']);
        Route::post('/edituc', [UserControlController::class, 'change']);

        Route::post('/uprole/{id}', [UproleController::class, 'index']);
});
Route::get( "/forget-password", [ForgetPasswordManager::class, 'forgetPassword'])->name("forget.password");
Route::post( "/forget-password", [ForgetPasswordManager::class, 'forgetPasswordPost'])->name("forget.password.post");
Route::get("/reset-password/{token}", [ForgetPasswordManager::class,"reswtPassword"])->name("reset.password");
Route::post("/reset-password", [ForgetPasswordManager::class,"resetPasswordPost"])->name("reset.password.post");
