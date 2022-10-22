<?php

use App\Http\Controllers\coditions\ConditionsController;
use App\Http\Controllers\post\postController;
use App\Models\conditions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();

});


Route::get('/', function () {

    return response()->json([
        //"version" => Route::app->version(),
        "time"   => Carbon::now()->toDateTime(),
        "php"    =>  phpversion()
    ]);
});





/** routes para register_user **/

Route::get('register_users', [\App\Http\Controllers\register_user\register_userController::class,'_index']);
Route::get('register_users/{id}', [\App\Http\Controllers\register_user\register_userController::class,'_show']);
Route::post('register_users', [\App\Http\Controllers\register_user\register_userController::class,'_store']);
Route::put('register_users/{id}', [\App\Http\Controllers\register_user\register_userController::class,'_update']);
Route::delete('register_users/{id}', [\App\Http\Controllers\register_user\register_userController::class,'_delete']);
Route::get('register_users/filter/market', [\App\Http\Controllers\register_user\register_userController::class,'filter']);
/** routes para tags **/

Route::get('tags', [\App\Http\Controllers\tags\tagsController::class,'_index']);
Route::get('tags/{id}', [\App\Http\Controllers\tags\tagsController::class,'_show']);
Route::post('tags', [\App\Http\Controllers\tags\tagsController::class,'_store']);
Route::put('tags/{id}', [\App\Http\Controllers\tags\tagsController::class,'_update']);
Route::delete('tags/{id}', [\App\Http\Controllers\tags\tagsController::class,'_delete']);

/** routes para detail_user_tags **/

Route::get('detail_user_tags', [\App\Http\Controllers\detail_user_tags\detail_user_tagsController::class,'_index']);
Route::get('detail_user_tags/{id}', [\App\Http\Controllers\detail_user_tags\detail_user_tagsController::class,'_show']);
Route::post('detail_user_tags', [\App\Http\Controllers\detail_user_tags\detail_user_tagsController::class,'_store']);
Route::put('detail_user_tags/{id}', [\App\Http\Controllers\detail_user_tags\detail_user_tagsController::class,'_update']);
Route::delete('detail_user_tags/{id}', [\App\Http\Controllers\detail_user_tags\detail_user_tagsController::class,'_delete']);
Route::delete('detail_user_tags/relation/tags', [\App\Http\Controllers\detail_user_tags\detail_user_tagsController::class,'deletetagsrelation']);


/** routes para conditions **/

Route::get('conditions', [\App\Http\Controllers\conditions\ConditionsController::class,'index']);
Route::get('conditions/{id}', [\App\Http\Controllers\conditions\ConditionsController::class,'show']);
Route::post('conditions', [\App\Http\Controllers\conditions\ConditionsController::class,'store']);
Route::put('conditions/{id}', [\App\Http\Controllers\conditions\ConditionsController::class,'update']);
Route::delete('conditions/{id}', [\App\Http\Controllers\conditions\ConditionsController::class,'destroy']);

//routes para lottery
Route::get('lottery/winners/{id}', [\App\Http\Controllers\lottery\LotteryController::class,'showWiners']);
Route::get('lottery', [\App\Http\Controllers\lottery\LotteryController::class,'index']);
Route::get('lottery/{id}', [\App\Http\Controllers\lottery\LotteryController::class,'show']);
Route::post('lottery', [\App\Http\Controllers\lottery\LotteryController::class,'store']);
Route::put('lottery/{id}', [\App\Http\Controllers\lottery\LotteryController::class,'update']);
Route::delete('lottery/{id}', [\App\Http\Controllers\lottery\LotteryController::class,'destroy']);
