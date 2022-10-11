<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log;
use Illuminate\Support\Facades\Auth;
use App\Imports\ImportContribution;
use Maatwebsite\Excel\Facades\Excel;
use App\User;
use App\Models\EmployeeContribution;
use App\Models\EmployeeContributionRequest;
use App\Models\MasterAccount;
use App\Models\MasterValueHistory;
use App\Models\MasterAccountEmployeeGained;

class ContributionController extends Controller
{
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }

    public function uploadContribution(Request $request){
        if($request->hasFile('file')) {
            Excel::import(new ImportContribution($request['date']), $request['file']);
            
            $master_account_amount = MasterAccount::select('master_account_amount')->get();
            
            $ov = MasterValueHistory::select('amount')
            ->orderBy('id', 'DESC')
            ->first();

            $difference =  $master_account_amount[0]['master_account_amount'] -  $ov['amount'];

            $percentage = ($difference / $ov['amount']) * 100;

            MasterValueHistory::create([
                'amount' => $master_account_amount[0]['master_account_amount'],
                'date_of_change' => date('Y-m-d'),
                'changed_by' => Auth::user()->username . ' uploaded a contribution for employees',
                'percentage' => round($percentage, 2),
                'difference' => $difference,
                'status' => 'increases'
            ]);

            return response()->json([
                'message' => 'Import Success!',
                'status' => 'SUCCESS'
            ]);    
        }

        return response()->json([
            'message' => 'Please upload a file.',
            'status' => 'ERROR.'
        ]);

    }

    public function fetch(){
        return EmployeeContribution::select('*')
        ->orderBy('created_at', 'DESC')
        ->get();

    }

    public function fetchIndvContribution(Request $request){
        return EmployeeContribution::select('*')
        ->where('username', $request['username'])
        ->orderBy('created_at', 'DESC')
        ->get();

    }

    public function fetchGainsandLoss(Request $request){
        return MasterAccountEmployeeGained::select('*')
        ->where('username', $request['username'])
        ->orderBy('created_at', 'DESC')
        ->get();

    }

    public function fetchTotalEmployeeContribution(){
        return EmployeeContribution::sum('employee_gained');
    }

    public function getContributionRequestCount(){
        $data = [
            'count' => EmployeeContributionRequest::where('status', 'Pending')->count()
        ];

        return $data;
    }


  

    

    

}
