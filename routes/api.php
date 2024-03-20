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
use App\Http\Controllers\ReplacmentController;
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

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']); 

 


Route::middleware(['AuthUser'])->group(function () {
    Route::post('/playerCreate', [PlayerController::class, 'store']);
    Route::post('/playerupdate',[PlayerController::class,'update']);
    Route::post('/playerdelete',[PlayerController::class, 'destroy']);

    Route::post('/sportCreate', [SportController::class, 'store']);
    Route::post('/sportupdate',[SportController::class,'update']);
    Route::post('/sportdelete',[SportController::class, 'destroy']);

    Route::post('/WearCreate', [WearController::class, 'store']);
    Route::post('/Wearupdate',[WearController::class,'update']);

    Route::post('/MatcheCreate', [MatcheController::class, 'store']);
    Route::post('/MatcheUpdate',[MatcheController::class,'update']);

    Route::post('/ReplacmentCreate', [ReplacmentController::class, 'store']);
    Route::post('/ReplacmentUpdate',[ReplacmentController::class,'update']);

    Route::post('/standingCreate', [StandingController::class, 'store']);
    Route::post('/standingUpdate',[StandingController::class,'update']);

    Route::post('/ClubCreate', [ClubController::class, 'store']);
     Route::post('/ClubUpdate',[ClubController::class,'update']);

     Route::post('/storeInormtionClub', [InformationController::class, 'storeInormtionClub']);
   Route::post('/storeInormtionSeasone', [InformationController::class, 'storeInormtionSeasone']);
    Route::post('/storeInormtionMetch', [InformationController::class, 'storeInormtionMetch']);
    Route::post('/Informationupdate',[InformationController::class,'update']);

    Route::post('/StatisticCreate', [StatisticController::class, 'store']);
    Route::post('/StatisticUpdate',[StatisticController::class,'update']) ;
    
    Route::post('/storeAssociaton', [AssociationController::class,'store']);
Route::post('/updateAssociaton', [AssociationController::class,'update']);

Route::post('/storeTopFans', [TopFansController::class,'store']);
Route::post('/updateTopFans',[TopFansController::class,'update']);

Route::post('/employeesstore', [employeesController::class,'store']);
Route::post('/employeesupdate', [employeesController::class,'update']);

Route::post('/employeesstore', [employeesController::class,'store']);
Route::post('/employeesupdate', [employeesController::class,'update']);

Route::post('/storePlans', [PlansController::class,'store']);
Route::post('/updatePlans', [PlansController::class,'update']);

Route::post('/BossessStore', [BossesController::class,'store']);
Route::post('/Bossesupdate', [BossesController::class,'update']);

Route::post('/Primesstore', [PrimesController ::class,'store']);
Route::post('/Primesupdate', [PrimesController ::class,'update']);

Route::post('/Videoupdate', [VideoController::class,'update']);
Route::post('/VideostoreVideoClubs', [VideoController::class,'storeVideoClubs']);
Route::post('/VideostoreVideoAssociation', [VideoController::class,'storeVideoAssociation']);
Route::post('/VideostoreVideoMatche', [VideoController::class,'storeVideoMatche']);

Route::post('/SeasoneStore', [SeasoneController ::class,'store']);
Route::post('/SeasoneUpdate', [SeasoneController::class,'update']);

});
Route::get('/indexplayer',[PlayerController::class,'index']);
 
Route::post('/player/show', [PlayerController::class, 'show']);
 
 
 
Route::get('/PlayerWithInfo',[PlayerController::class,'PlayerWithInfo']);
Route::get('/viewnews',[InformationController::class,'index']);

 
Route::post('/sport/show', [SportController::class, 'show']);
 

 
Route::post('/showPlayerClothings',[WearController::class, 'showPlayerClothings']);

 
Route::post('/showMatcheDatetime',[MatcheController::class, 'showMatcheDatetime']);
Route::get('/showMatcheStatus',[MatcheController::class, 'showMatcheStatus']);

 

Route::get('/getDisplayedMatches',[MatcheController::class, 'getDisplayedMatches']);
Route::get('/getDisplayedMatchesLogo',[MatcheController::class, 'getDisplayedMatchesLogo']);
Route::get('/getDisplayedMatchesLogoHalf',[MatcheController::class, 'getDisplayedMatchesLogoHalf']);
 
Route::post('/standings', [StandingController::class, 'index']);
 

 
Route::post('/showRegular', [ClubController::class, 'showRegular']);
Route::post('/showStrategy', [ClubController::class, 'showStrategy']);
 
Route::post('/showSlider', [ClubController::class, 'showSlider']);
Route::post('/Statistic', [StatisticController::class, 'index']);


Route::post('/getDisplayedMatcheWithReplecment',[MatcheController::class, 'getDisplayedMatcheWithReplecment']);

/*Associaton*/
Route::post('/viewAssociaton', [AssociationController::class,'show']);
 
/*End Association Api */

/*Topfans*/
Route::post('/TopFansview', [TopFansController::class,'show']);
 
/*End topfans */
/*Employee */
Route::post('/employeesindex', [employeesController::class,'index']);
 
/*end employee*/

/*plans*/
Route::post('/viewPlans', [PlansController::class,'show']);
 
/*end plans*/
/*bosses */
Route::post('/Bossesshow', [BossesController::class,'show']);
Route::get('/BossesShowALL', [BossesController::class,'index']);
/*end bosses */

/*prime */
Route::get('/PrimesPersonalIndex', [PrimesController ::class,'index']);
Route::get('/PrimesClublIndex', [PrimesController ::class,'index1']);
/*end prime */

/*video */
Route::post('/indexvideoclub', [VideoController::class,'indexvideoclub']);
Route::post('/indexvideoMeche', [VideoController::class,'indexvideoMeche']);
/*end  video */
//Route::post('/Associaton', [AssociationController::class,'index']);
Route::post('/Seasoneindex', [SeasoneController::class,'index']);






 