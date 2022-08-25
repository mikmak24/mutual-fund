<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Models\MasterAccount;

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
        return $data = [
            'status' => 'SUCCESS',
            'message' => 'Updated Successfully...'
        ];
    }

}
