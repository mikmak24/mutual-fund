<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Log;

class LoginController extends Controller
{
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }

    public function login(Request $request){
        // Session::put('username', $request['username']);
        // Session::save();
        $request->session()->flush();


        Log::alert($request->session()->all());

        // if($request->session()->has('my_name')){
        // Log::alert($request->session()->get('my_name'));
        // }

        //Log::alert($request->session()->all());

        dd();
    

    }
}
