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
use App\Models\Contribution;

class EmployeesController extends Controller
{
    public function __construct()
    {
       
    }

    public function fetch(){
        return User::select('users.username',
        DB::raw('SUM(contributions.employee_contribution) as total_employee_contr'), 
        DB::raw('SUM(contributions.employer_contribution) as total_employer_contr'), 
        )
        ->leftJoin('contributions', 'users.username', '=', 'contributions.user_id')
        ->groupBy('users.username')
        ->get();

    }

  

    

    

}
