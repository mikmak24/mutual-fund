<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Controllers
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\EmployeesController;

use App\Http\Controllers\MasterAccountController;

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

        //Contribution
        Route::post('uploadcontribution', [ContributionController::class, 'uploadContribution']);
        Route::get('contributionlist', [ContributionController::class, 'fetch']);

        //Employee
        Route::get('employeeslist', [EmployeesController::class, 'fetch']);
        Route::get('employeesrequest', [EmployeesController::class, 'fetchemployeesrequest']);

        Route::post('updateContribution', [EmployeesController::class, 'updateContribution']);
        Route::get('fetchEmployeeContribution', [EmployeesController::class, 'fetchEmployeeContribution']);
        Route::get('fetchEmpDashboardCardDetails', [EmployeesController::class, 'fetchEmpDashboardCardDetails']);

        //MasterAccount
        Route::get('masteraccount', [MasterAccountController::class, 'fetch']);
        Route::post('updateMasterAccount', [MasterAccountController::class, 'updateMasterAccount']);


    });


});