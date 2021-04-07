<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
//use App\Http\Traits\ValidateAndCreatePatient;
use App\Http\Controllers\Api\Parser;

use Auth;
use JwtAuth;
use App\User;

class AuthController extends Controller
{
//	use ValidateAndCreatePatient;

    public function login(Request $request)
    {
    	$credentials = $request->only('email', 'password');
       // dd('hola: ', $credentials);
    	// if (Auth::guard('api')->attempt($credentials)) {
		//     $user = Auth::guard('api')->user();
		//     // $jwt = JwtAuth::generateToken($user);
        //     $jwt = $user->createToken($user);
		//     $success = true;

		//    $data = compact('user');
		//     return compact('success', 'data', 'jwt');
		// } else {
		//     // Return response for failed attempt.
		// 	$error = false;
		// 	$message = 'credenciales invalidas';
		// 	return compact('error', 'message');
		// }

        if(Auth::attempt($credentials)){
            $user = Auth::user();
            $success['token'] =  $user->createToken('Password Token')-> accessToken;

            return response()->json(['success' , $success, $user]);
        }
        else{
            return response()->json(['error','credenciales invalidas'], 401);
        }

    }

    public function logout(Request $request)
    {
       // dd('no');
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Se ha desconectado correctamente',
        ]);

        // Auth::guard('api')->logout();
        // $success = true;
        // return compact('success');


    }

    public function register(Request $request)
    {
    	$this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        Auth::guard('api')->login($user);

        $jwt = JwtAuth::generateToken($user);
	    $success = true;

	    return compact('success', 'user', 'jwt');
    }

    // public function logout()
    // {
    //     return Auth::guard('api')->user();
    // }
}
