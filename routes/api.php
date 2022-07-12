<?php

use App\Http\Controllers\post\postController;
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




