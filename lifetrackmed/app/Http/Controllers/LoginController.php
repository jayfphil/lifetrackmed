<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
	{  		      

	    $val = $this->validateLogin($request);
	    $asd = Auth::attempt(array(
          'email' => $request->email,
          'password' => $request->password
        ));

	    if($val['success']==true) {

	    	if ($this->attemptLogin($request)) {

		        $user = $this->guard()->user();
		        $user->generateToken();

		        return response()->json([
		            'data' => $user->toArray(),
		        ]);
		    } else {
		    	return response()->json(['error' => "invalid credentials"], 400);
		    }

	    } else {
	    	return response()->json($val, 201);
	    }

	}

	protected function validateLogin(Request $request)
    {
       	$rules = [
		    'email' => 'required|email',
		    'password' => 'required',
		];

		$response = array('response' => '', 'success'=>true);
		$validator = Validator::make($request->all(), $rules);
	    if ($validator->fails()) {
	        $response['response'] = $validator->messages();
	        $response['success'] = false;
	    }
	    return $response;
    }

    public function attemptLogin(Request $request)
    {
        $userdata = array(
          'email' => $request->email,
          'password' => $request->password
        );

        if (Auth::attempt($userdata)) {
            // Authentication passed...
            return true;
        }
        return false;
    }

    protected function guard()
	{
	    return Auth::guard();
	}

	public function logout(Request $request)
	{
	    $user = Auth::guard('api')->user();

	    if ($user) {
	        $user->api_token = null;
	        $user->save();
	    }

	    return response()->json(['data' => 'User logged out.'], 200);
	}
}
