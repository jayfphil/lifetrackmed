<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(Request $request)
	{
	    // Here the request is validated. The validator method is located
	    // inside the RegisterController, and makes sure the name, email
	    // password and password_confirmation fields are required.
	    $val = $this->validator($request);

	    if($val['success']==true) {

	    	// A Registered event is created and will trigger any relevant
		    // observers, such as sending a confirmation email or any 
		    // code that needs to be run as soon as the user is created.

		    $request->merge([
			    'password' => Hash::make($request->password),
			]);
		
		    event(new Registered($user = User::create($request->all())));

		    // After the user is created, he's logged in.
		    $this->guard()->login($user);

		   	// And finally this is the hook that we want. If there is no
		    // registered() method or it returns null, redirect him to
		    // some other URL. In our case, we just need to implement
		    // that method to return the correct response.
		    return $this->registered($request, $user);
	    }

	    else {
	    	return response()->json($val, 201);
	    }
	    
	}

	protected function registered(Request $request, $user)
	{
	    $user->generateToken();

	    return response()->json(['data' => $user->toArray()], 201);
	}

	protected function guard()
	{
	    return Auth::guard();
	}

	protected function validator(Request $request)
    {
       	$rules = [
		    'email' => 'required|email',
		    'password' => 'required',
		    'name' => 'required',
		];

		$response = array('response' => '', 'success'=>true);
		$validator = Validator::make($request->all(), $rules);
	    if ($validator->fails()) {
	        $response['response'] = $validator->messages();
	        $response['success'] = false;
	    }
	    return $response;
    }
}
