<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function  register(Request $request){

       $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required','email','unique:users'],
            'password' => ['required','min:8'],
            'confirm_password' => ['required','same:password'],
        ]);

        if ($validator->fails()) {
            $errs =array();
            foreach (array_values($validator->getMessageBag()->getMessages()) as $err){
                $errs = array_merge_recursive($err);
            }
            return response()->json($errs, 500);
        }
        $password = bcrypt(trim($request->get('password')));
        User::create([
            'name'=>trim($request->get('name')),
            'email'=>trim($request->get('email')),
            'password'=>$password,
        ]);

        //TODO : Probably and EVENT to send  a welcome email after registration

        return response()->json(['statusCode'=>0,'statusMessage'=>'Account Created Successfully'], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['statusCode'=>1,'statusMessage'=>'Login Failed. Check your credentials and try again'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }


    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }


    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'email' => auth()->user()->email,
            'name' =>  auth()->user()->name,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

}
