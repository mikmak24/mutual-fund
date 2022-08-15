<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Log;

class LoginController extends Controller
{
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }

    public function login(Request $request){
        $password = Hash::make($request['password']);
        Session::put('username', $request['username']);
        Session::put('password', $password);
        Session::save();

        $data = [
            'message' => 'SUCCESS',
            'username' => $request['username'],
            'token' => Session::getId(),
            'isAuthenticated' => TRUE
        ];

        return response()->json($data);


    }

    public function logout(Request $request){
        $request->session()->forget('username');
        $request->session()->forget('password');

        return response()->json([
            'message' => 'SUCCESS',
            'username' => '',
            'token' => '',
            'isAuthenticated' => FALSE

        ]);

    }

}
