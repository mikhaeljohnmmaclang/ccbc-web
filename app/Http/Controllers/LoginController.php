<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Validator;


class LoginController extends Controller
{
    protected $login;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login() {
    	/*return view('page');*/
        return view('login');
    }

    public function authenticate(Request $request) {
        try {
			$validator = Validator::make($request->all(), ['email' => 'required|exists:users', 'password' => 'required']);
	        if($validator->fails()){
	            return 'no_user';
	        }
	        else{
	            $credentials = array('email' => $request['email'], 'password' => $request['password'], 'status' => 1);
	            if(Auth::attempt($credentials)){
	                return 'success';
	            }
	            else{
	            	return 'no_user';
	            }
	        }
		} catch (\Exception $e) {
			return $e;
		}
    }

    public function logout() {
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }
}
