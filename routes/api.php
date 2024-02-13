<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\SportController;
use App\Http\Controllers\WearController;
use App\Http\Controllers\MatcheController;
use App\Http\Controllers\StandingController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StatisticController;
 
use App\Http\Controllers\AssociationController;
use App\Http\Controllers\employeesController;
use App\Http\Controllers\PrimesController;
use App\Http\Controllers\TopFansController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\BossesController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\SeasoneController;
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
Route::get('/PlayerWithInfo',[PlayerController::class,'PlayerWithInfo']);
Route::get('/viewnews',[InformationController::class,'index']);

Route::post('/sportCreate', [SportController::class, 'store']);
Route::post('/sport/show', [SportController::class, 'show']);
Route::post('/sportupdate',[SportController::class,'update']);
Route::post('/sportdelete',[SportController::class, 'destroy']);

Route::post('/WearCreate', [WearController::class, 'store']);
Route::post('/showPlayerClothings',[WearController::class, 'showPlayerClothings']);

Route::post('/MatcheCreate', [MatcheController::class, 'store']);
Route::post('/showMatcheDatetime',[MatcheController::class, 'showMatcheDatetime']);
Route::get('/showMatcheStatus',[MatcheController::class, 'showMatcheStatus']);

Route::get('/getDisplayedMatches',[MatcheController::class, 'getDisplayedMatches']);
Route::get('/getDisplayedMatchesLogo',[MatcheController::class, 'getDisplayedMatchesLogo']);
Route::get('/getDisplayedMatchesLogoHalf',[MatcheController::class, 'getDisplayedMatchesLogoHalf']);
 
Route::get('/standings', [StandingController::class, 'index']);
Route::post('/standingCreate', [StandingController::class, 'store']);

Route::post('/showRegular', [ClubController::class, 'showRegular']);
Route::post('/showStrategy', [ClubController::class, 'showStrategy']);
 
Route::post('/showSlider', [ClubController::class, 'showSlider']);
Route::get('/Statistic', [StatisticController::class, 'index']);


Route::post('/getDisplayedMatcheWithReplecment',[MatcheController::class, 'getDisplayedMatcheWithReplecment']);


Route::post('/viewAssociaton', [AssociationController::class,'show']);
//Route::post('/Associaton', [AssociationController::class,'index']);
Route::post('/Seasoneindex', [SeasoneController::class,'index']);
Route::post('/TopFansview', [TopFansController::class,'show']);
Route::post('/viewPlans', [PlansController::class,'show']);
Route::post('/Bossesshow', [BossesController::class,'show']);
Route::post('/Videoindex', [VideoController::class,'index']);
Route::post('/employeesindex', [employeesController::class,'index']);
Route::get('/Primesindex', [PrimesController ::class,'index']);
