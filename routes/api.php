<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Controllers
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContributionController;


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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['middleware' => ['web']], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [LoginController::class, 'login']);
        Route::post('logout', [LoginController::class, 'logout'])->middleware('auth');
    });

    Route::middleware('auth')->group( function () {
        Route::post('logout', [LoginController::class, 'logout']);
        Route::post('uploadcontribution', [ContributionController::class, 'uploadContribution']);
    });


});