<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\SportController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/indexplayer',[PlayerController::class,'index']);
Route::post('/playerCreate', [PlayerController::class, 'store']);
Route::post('/player/show', [PlayerController::class, 'show']);
Route::post('/playerupdate',[PlayerController::class,'update']);

Route::post('/playerdelete',[PlayerController::class, 'destroy']);

Route::post('/indexinformation',[InformationController::class,'index']);

Route::post('/sportCreate', [SportController::class, 'store']);
Route::post('/sport/show', [SportController::class, 'show']);
Route::post('/sportupdate',[SportController::class,'update']);
Route::post('/sportdelete',[SportController::class, 'destroy']);