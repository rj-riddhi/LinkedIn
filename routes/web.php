<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if((session()->get('UsersName')))
    {
        return redirect('/welcome/'.session("UsersName"));
    }
    else
    {
    return redirect('/userlogin');
    }
});
Route::view('/Login','Login');
Route::get('/logout',[UserController::class,"logout"]);
Route::view('/userlogin','userlogin');
Route::view('/ForgotModal','ForgotPassword');
Route::get('/welcome/{data}',function ($data) {
    return view('welcome',['name'=>$data]);
});
Route::post("/UserLogin",[UserController::class,"UserLogin"]);

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
    // ->name('dashboard');
    
    
// });
Route::get("/dashboard/users",[UserController::class,"getUsers"]);
Route::get('/connections/{data}',function($data){
    return view('connections',['name'=>$data]);
});

Route::get("/index/{name}/{name2}/{senderId}/{receiverId}/{csrf}",function($name,$name2,$senderId,$receiverId,$csrf){
    return view('index',['name'=>$name,'name2'=>$name2,'senderId'=>$senderId,'receiverId'=>$receiverId,'csrf'=>$csrf]);
});


// Route for mail
Route::get('mail/{email}', [MailController::class,"index"]);

// Route for store msg
Route::get("/storeMessage/{data}",[UserController::class,"storeMessage"]);

// Route::POST('/request', function()
// {
//     include public_path().'server.js';
// });
