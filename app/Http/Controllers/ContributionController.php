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
        Log::alert("------------");
        Log::alert($request['date']);
        if($request->hasFile('file')) {
            Excel::import(new ImportContribution, $request['file']);
        }

    }

  

    

    

}
