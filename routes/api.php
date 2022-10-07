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
        Route::get('countContributionRequest', [ContributionController::class, 'getContributionRequestCount']);
        Route::post('fetchIndvContribution', [ContributionController::class, 'fetchIndvContribution']);

        Route::post('fetchGainsandLoss', [ContributionController::class, 'fetchGainsandLoss']);
        Route::get('fetchTotalEmployeeContribution', [ContributionController::class, 'fetchTotalEmployeeContribution']);


        //Employee
        Route::get('employeeslist', [EmployeesController::class, 'fetch']);
        Route::get('employeesrequest', [EmployeesController::class, 'fetchemployeesrequest']);
        Route::get('fetchChartData', [EmployeesController::class, 'fetchChartData']);
        
        Route::get('fetchActiveInActiveEmployee', [EmployeesController::class, 'fetchActiveInActiveEmployee']);

        Route::get('fetchIndvDashboardDetails', [EmployeesController::class, 'fetchIndvDashboardDetails']);


        Route::post('updateEmpContribution', [EmployeesController::class, 'updateContribution']);
        Route::post('modifyContribution', [EmployeesController::class, 'modifyContribution']);

        Route::get('fetchEmployeeContribution', [EmployeesController::class, 'fetchEmployeeContribution']);
        Route::get('fetchEmpDashboardCardDetails', [EmployeesController::class, 'fetchEmpDashboardCardDetails']);
        Route::get('downloadEmployees', [EmployeesController::class, 'downloadEmployees']);


        Route::post('acceptContribution', [EmployeesController::class, 'acceptContribution']);
        Route::post('declineContribution', [EmployeesController::class, 'declineContribution']);

        Route::post('updateEmployeeStatus', [EmployeesController::class, 'updateEmployeeStatus']);

        Route::post('fetchContributionHistory', [EmployeesController::class, 'fetchContributionHistory']);

        Route::get('fetchNotifications', [EmployeesController::class, 'fetchNotifications']);
        Route::post('markAsReadNotf', [EmployeesController::class, 'markAsReadNotf']);




        //MasterAccount
        Route::get('masteraccount', [MasterAccountController::class, 'fetch']);
        Route::post('updateMasterAccount', [MasterAccountController::class, 'updateMasterAccount']);
        Route::get('fetchLineChartData', [MasterAccountController::class, 'fetchLineChartData']);
        Route::get('fetchMasterValueHistory', [MasterAccountController::class, 'fetchMasterValueHistory']);
    });
});