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

class MasterAccountController extends Controller
{
    public function __construct()
    {
       
    }

    public function fetch(){
        return MasterAccount::select('*')->get();
    }

    public function updateMasterAccount(Request $request){
        MasterAccount::find(1)->update(['master_account_amount' => $request['value']]);
        MasterValueHistory::create([
            'amount' => $request['value'],
            'date_of_change' => date('Y-m-d'),
            'changed_by' => 'Updated by ' .  Auth::user()->username
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

}
