<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Models\MasterAccount;
use App\Models\MasterValueHistory;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterAccountEmployeeGained;

class MasterAccountController extends Controller
{
    public function __construct()
    {
       
    }

    public function fetch(){
        return MasterAccount::select('*')->get();
    }

    public function updateMasterAccount(Request $request){
        $ov = MasterValueHistory::select('amount')
        ->orderBy('id', 'DESC')
        ->first();

        if($ov['amount'] == 0){
            $ov['amount'] = 1;
        }

        $nv = $request['value'];
        $sbt = ($nv - $ov['amount']);
        $percentage = ($sbt / $ov['amount']) * 100;

        $status = 'increases';

        if($sbt < 0){
            $status = 'decreases';
        }

        $employees = User::where('is_admin', 0)->where('is_active', 1)->get();
        foreach($employees as $employee){
            $employee_monthly_percentage = $employee->employee_monthly_contribution;

            $gained = ($employee_monthly_percentage / 100) * $sbt;
            User::where('username', $employee->username)->update(['employee_total_share' => ($employee->employee_total_share + $gained)]);

           
            MasterAccountEmployeeGained::create([
                'username' => $employee->username,
                'amount' => $gained,
                'amount_total' => ($employee->employee_total_share + $gained),
                'date_of_change' => date('Y-m-d'),
                'status' => $status,
                'percentage' => $employee_monthly_percentage
            ]);        
        
        }

        MasterAccount::find(1)->update(['master_account_amount' => $request['value']]);
        MasterValueHistory::create([
            'amount' => $request['value'],
            'date_of_change' => date('Y-m-d'),
            'changed_by' => 'Updated by ' .  Auth::user()->username,
            'percentage' => round($percentage, 2),
            'difference' => $sbt,
            'status' => $status
        ]);

        return $data = [
            'status' => 'SUCCESS',
            'message' => 'Updated Successfully...'
        ];
    }

    public function fetchLineChartData(){
        return MasterValueHistory::select('amount', 'changed_by', 'created_at', 'updated_at',
        DB::raw('CONVERT(created_at,CHAR)AS date_of_change'), 
        )
        ->orderBy('id', 'ASC')
        ->get();
    }

    public function fetchMasterValueHistory(){
        return MasterValueHistory::select('amount', 'changed_by', 'created_at', 'updated_at', 'percentage', 'difference', 'status',
        DB::raw('CONVERT(created_at,CHAR)AS date_of_change'), 
        )
        ->orderBy('id', 'DESC')
        ->get();
    }

}
