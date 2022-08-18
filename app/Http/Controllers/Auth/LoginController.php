<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Log;
use App\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Ui\Presets\React;

class LoginController extends Controller
{
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }

    public function slogin(Request $request){
        $data = [];
      
        $username = strtoupper($request["username"]);
        $password = strtoupper($request["password"]);

        $xml = 
        "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
        <!DOCTYPE IDMS-XML SYSTEM \"http://www.eclipseinc.com/dtd/IDMS-XML.dtd\">
        <IDMS-XML>
            <CheckEclipseLogin>
                <Security>
                    <SitePass>
                        <LoginID>IDMS</LoginID>
                        <Password>SWPLUMB89</Password>
                    </SitePass>
                </Security>
                <UserName>{$username}</UserName>
                <UserPassword>{$password}</UserPassword>
            </CheckEclipseLogin>
        </IDMS-XML>";

        $temp = self::eclipse_xml($xml);
        $json = json_encode(simplexml_load_string($temp));
        $errStr = 'ErrorMessage';
        $xml = simplexml_load_string($temp);

       

        if (Str::contains($json, $errStr) || $temp == "No response generated.") {
            $data = [
                'status' => 'ERROR',
                'message' => 'INVALID CREDENTIALS',
                'username' => '',
                'isAuthenticated' => FALSE
            ];


        } else if ((string)($xml->CheckEclipseLoginResponse->StatusResult->attributes()->Success) != "No") {

            $request->validate([
                'username' => 'required|string|max:255'
            ]);

            $user = User::where('username', '=', $request['username'])->first();
            if ($user === null) {
               
                User::create([
                    'username' => $request['username'],
                    'password' => Hash::make($request['password']),
                ]);
            }

            

            $fieldType = 'username';

            if(auth()->attempt(array($fieldType => $request['username'], 'password' => $request['password'])))
            {
                $data = [
                    'status' => 'SUCCESS',
                    'message' => 'SUCCESSFULL LOGIN...',
                    'username' => Auth::user()->username,
                    'isAuthenticated' => TRUE
                ];


            } 
    
        }

        return response()->json($data);


    }

    public function login(Request $request){

        $request->validate([
            'username' => 'required|string|max:255'
        ]);

        $user = User::where('username', '=', $request['username'])->first();
        if ($user === null) {
           
            User::create([
                'username' => $request['username'],
                'password' => Hash::make($request['password']),
            ]);
        }

        

        $fieldType = 'username';

        if(auth()->attempt(array($fieldType => $request['username'], 'password' => $request['password'])))
        {
            $data = [
                'status' => 'SUCCESS',
                'message' => 'SUCCESSFULL LOGIN...',
                'username' => Auth::user()->username,
                'isAuthenticated' => TRUE
            ];


        } 

    

        return response()->json($data);


    }

    public function logout(Request $request){
        Auth::logout();

        return response()->json([
            'status' => 'LOGOUT',
            'message' => 'SUCCESS',
            'username' => '',
            'token' => '',
            'isAuthenticated' => FALSE
        ]);

    }

    public function eclipse_xml($xml) {
        $headers = array(
            'Content-Type: text/xml',
            'Content-Length: ' . strlen($xml)
        );

        $curl = curl_init("http://192.168.2.205/eserv/eclipse.ecl");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
        $temp = curl_exec($curl);
        curl_close($curl);

        return $temp;
    }

    

}
