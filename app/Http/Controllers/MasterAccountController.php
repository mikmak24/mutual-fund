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
use App\Models\EmployeeContribution;

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

        $employees = User::select('*',
            DB::raw('(SELECT SUM(amount) FROM `master_account_employee_gained` AS maeg WHERE maeg.username=users.username) total_employee_gained'), 
            DB::raw('(SELECT SUM(employee_contribution) FROM `employee_contributions` AS empye_cntr WHERE empye_cntr.username=users.username) total_employee_contr'), 
            DB::raw('(SELECT SUM(employer_contribution) FROM `employee_contributions` AS empyr_cntr WHERE empyr_cntr.username=users.username) total_employer_contr'), 
            DB::raw('(SELECT SUM(employee_gained) FROM `employee_contributions` AS empye_gained WHERE empye_gained.username=users.username) total_contribution'), 
            )
        ->where('is_active', 1)
        ->where('is_admin', 0)
        ->get();
    
        foreach($employees as $employee){
            $employee_monthly_percentage = $employee->employee_monthly_contribution;

            $gained = ($employee_monthly_percentage / 100) * $sbt;

            $amount_total = $this->calculateAmountEarned($employee->total_contribution, $request['value']);
            User::where('username', $employee->username)->update(['employee_total_share' => $amount_total]);

            MasterAccountEmployeeGained::create([
                'username' => $employee->username,
                'amount' => $gained,
                'amount_total' => $amount_total,
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

    public function calculateAmountEarned($total, $master_account_amount){
        $percentage = $this->calculatePercentageEarned($total);
        $result = (($percentage / 100) * $master_account_amount);
        return number_format($result,2);
    }

    public function calculatePercentageEarned($total){
        $total_employees_contribution = $this->fetchTotalEmployeeContribution();
        $val = ($total / $total_employees_contribution) * 100;
        return number_format($val,2);
    }

    public function fetchTotalEmployeeContribution(){
        return EmployeeContribution::sum('employee_gained');
    }

}
