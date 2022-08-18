<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log;
use Illuminate\Support\Facades\Auth;

use App\Imports\ImportContribution;
use Maatwebsite\Excel\Facades\Excel;

class ContributionController extends Controller
{
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }

    public function uploadContribution(Request $request){
        if($request->hasFile('file')) {
            Excel::import(new ImportContribution($request['date']), $request['file']);

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

  

    

    

}
