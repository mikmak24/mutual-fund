<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log;
use Illuminate\Support\Facades\Auth;
use App\Imports\ImportContribution;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Models\EmployeeContribution;
use App\Models\EmployeeContributionRequest;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\EmployeeContributionHistory;
use App\Models\EmployeeNotification;

class EmployeesController extends Controller
{
    public function __construct()
    {
       
    }

    public function fetch(){
        return User::select('users.username', 'users.is_active', 'users.created_at', 'users.updated_at',
        DB::raw('SUM(employee_contributions.employee_contribution) as total_employee_contr'), 
        DB::raw('SUM(employee_contributions.employer_contribution) as total_employer_contr'), 
        DB::raw('SUM(employee_contributions.employee_gained) as total_employee_shares'), 

        )
        ->leftJoin('employee_contributions', 'users.username', '=', 'employee_contributions.username')
        ->groupBy('users.username')
        ->where('users.is_admin', 0)
        ->get();
    }

    public function markAsReadNotf(Request $request){
        EmployeeNotification::where('id', $request['id'])->update([
            'is_read' => TRUE
        ]);

        return $data = [
            'status' => 'SUCCESS',
            'message' => 'Updated Successfully...'
        ];
    }

    public function fetchChartData(){

        return EmployeeContribution::select('username', 'employee_contribution', 'employer_contribution',
        DB::raw('CONVERT(date_of_contribution,CHAR)AS year'), 
        )
        ->where('username', Auth::user()->username)
        ->orderBy('created_at', 'ASC')
        ->get();
    }

    public function fetchActiveInActiveEmployee(){

        $active = User::where('is_active', '1')->count();
        $inactive = User::where('is_active', '0')->count();

        return $data = [
            'active' => $active,
            'inactive' => $inactive
        ];
    }

    public function fetchemployeesrequest(){
        return EmployeeContributionRequest::select('*')
        ->orderBy('created_at', 'DESC')
        ->get();
    }

    public function fetchNotifications(){
        return EmployeeNotification::select('*')
        ->where('to', Auth::user()->username)
        ->orderBy('created_at', 'DESC')
        ->get(); 
    }

    public function updateContribution(Request $request){
        EmployeeContributionRequest::create([
            'username' => Auth::user()->username,
            'requested_amount' =>  $request['contribution'],
            'status' => 'Pending' ,
            'date_of_request' => date("Y/m/d"),
            'approved_by' => 'not-yet'
           
        ]);

        return $data = [
            'status' => 'SUCCESS',
            'message' => 'Updated Successfully...'
        ];

    }

    public function modifyContribution(Request $request){
        EmployeeContribution::where('id', $request[0]['id'])->update([
            'employee_contribution' => $request[0]['employee_contribution'],
            'employer_contribution' => $request[0]['employer_contribution'],
            'employee_gained' => ($request[0]['employee_contribution'] +  $request[0]['employer_contribution'])
        ]);

        EmployeeContributionHistory::create([
            'employee_contribution_id' =>  $request[0]['id'],
            'username' => $request[0]['username'],
            'employee_contribution' =>  $request[0]['employee_contribution'],
            'employer_contribution' =>  $request[0]['employer_contribution'],
            'employee_gained' => ($request[0]['employee_contribution'] +  $request[0]['employer_contribution']),
            'employee_contribution_change' => is_string($request[0]['employee_contribution']) ?? 0,
            'employer_contribution_change' => is_string($request[0]['employer_contribution']) ?? 0,
            'updated_by' => Auth::user()->username

        ]);

        EmployeeNotification::create([
            'from' => Auth::user()->username,
            'to' =>  $request[0]['username'],
            'message' =>  'Admin ' .  Auth::user()->username . ' modified a contribution to you, Please check or contact administration for more details',
            'is_read' =>  false,
        ]);

        return $data = [
            'status' => 'SUCCESS',
            'message' => 'Updated Successfully...'
        ];

    }
    

    public function acceptContribution(Request $request){
        EmployeeContributionRequest::where('id', $request['id'])->update([
            'status' => 'Accepted',
            'approved_by' => Auth::user()->username
        ]);

        User::where('username', $request['username'])->update([
            'employee_monthly_contribution' => $request['value']
        ]);

        return $data = [
            'status' => 'SUCCESS',
            'message' => 'Updated Successfully...'
        ];

    }

    public function declineContribution(Request $request){
        EmployeeContributionRequest::where('id', $request['id'])->update([
            'status' => 'Declined',
            'approved_by' => 'Declined'
        ]);

        return $data = [
            'status' => 'SUCCESS',
            'message' => 'Declined Successfully...'
        ];
 
    }

    public function updateEmployeeStatus(Request $request){
        User::where('username', $request['username'])->update([
            'is_active' => $request['is_active'],
        ]);

        return $data = [
            'status' => 'SUCCESS',
            'message' => 'Updated Successfully...'
        ];

    }

    public function fetchContributionHistory(Request $request){
        return EmployeeContributionHistory::select('*')
        ->where('username', $request['username'])
        ->where('employee_contribution_id', $request['id'])
        ->orderBy('created_at', 'DESC')
        ->get();
    }

    public function fetchEmployeeContribution(){
        return EmployeeContribution::where('username', Auth::user()->username)->get();
    }

    public function downloadEmployees(){
        return User::select('*')
        ->where('is_admin', '=', 0)
        ->where('is_active', '=', 1)
        ->get();
    }

    public function fetchEmpDashboardCardDetails(){
        return User::select('users.username', 'users.employee_monthly_contribution',
        DB::raw('SUM(employee_contributions.employee_contribution) as total_employee_contr'), 
        DB::raw('SUM(employee_contributions.employer_contribution) as total_employer_contr'), 
        DB::raw('count(employee_contributions.employer_contribution) as total_month_contr'), 
        )
        ->leftJoin('employee_contributions', 'users.username', '=', 'employee_contributions.username')
        ->groupBy('users.username', 'users.employee_monthly_contribution')
        ->where('users.username', Auth::user()->username)
        ->get();
    }

    

}
