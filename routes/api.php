<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::POST("/connectionrequest",[UserController::class,"makerequest"]);
Route::POST("/Loginuser",[UserController::class,"LoginUser"]);
Route::POST("/UploadProfile",[UserController::class,"UploadProfile"]);

Route::POST("/acceptequest",[UserController::class,"acceptRequest"]);
Route::POST("/rejectrequest",[UserController::class,"rejectrequest"]);
Route::POST("/cancelrequest",[UserController::class,"cancelrequest"]);
Route::POST("/chatting",[UserController::class,"chatting"]);
Route::POST("/getSuggestions",[UserController::class,"getSuggestions"]);

Route::POST("/getProfile",[UserController::class,"getProfile"]);
Route::POST("/getUserStatus",[UserController::class,"getUserStatus"]);
Route::POST("/getUserId",[UserController::class,"getUserId"]);
Route::POST("/loadMessages",[UserController::class,"loadMessages"]);
Route::POST("/uploadVideoFile",[UserController::class,"uploadVideoFile"]);
// Route::POST("/changeStatus",[UserController::class,"changeStatus"]);

// Route::POST('/request', function()
// {
//     include public_path().'server.js';
// });

