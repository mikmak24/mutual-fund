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

class EmployeesController extends Controller
{
    public function __construct()
    {
       
    }

    public function fetch(){
        return User::select('users.username',
        DB::raw('SUM(employee_contributions.employee_contribution) as total_employee_contr'), 
        DB::raw('SUM(employee_contributions.employer_contribution) as total_employer_contr'), 
        )
        ->leftJoin('employee_contributions', 'users.username', '=', 'employee_contributions.username')
        ->groupBy('users.username')
        ->where('users.is_admin', 0)
        ->get();
    }

    public function updateContribution(Request $request){
        User::find(Auth::user()->id)->update(['employee_monthly_contribution' => $request['contribution']]);

        return $data = [
            'status' => 'SUCCESS',
            'message' => 'Updated Successfully...'
        ];

    }

    public function fetchEmployeeContribution(){
        return EmployeeContribution::select('*')
        ->where('user_id', Auth::user()->username)
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
