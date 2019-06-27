<?php

namespace App\Http\Controllers;

use App\Notifications\PasswordReset;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','resetpwd']]);
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

    public function resetpwd(Request $request){
        //cHANGE pASSWORD
        if($request->has('token')){
            $validator = Validator::make($request->all(), [
                'email' => ['required','email'],
                'token' => ['required'],
                'password' => ['required','min:8'],
                'confirm_password' => ['required','same:password']
            ]);

            if ($validator->fails()) {
                $errs =array();
                foreach (array_values($validator->getMessageBag()->getMessages()) as $err){
                    $errs = array_merge_recursive($err);
                }
                return response()->json($errs, 500);
            }
            $password = bcrypt(trim($request->get('password')));
            $email = trim($request->get('email'));
            $token = trim($request->get('token'));
            $user = User::where('email',$email)->where('is_pwd_reset',true)->where('password_reset_token',$token)->first();
            if(null == $user){
                return response()->json(['statusCode'=>1,'statusMessage'=>"No account exist for ${email}, OR The token you provided is not valid"], 500);
            }

            $user->password = $password;
            $user->password_reset_token = '';
            $user->is_pwd_reset = false;
            $user->save();

            return response()
                ->json([
                    'statusCode'=>0,
                    'statusMessage'=>"Password changed Successfully.",
                    'payload'=>[]], 200);
        }else{
            //Reset Password
            $validator = Validator::make($request->all(), [
                'email' => ['required','email']
            ]);

            if ($validator->fails()) {
                $errs =array();
                foreach (array_values($validator->getMessageBag()->getMessages()) as $err){
                    $errs = array_merge_recursive($err);
                }
                return response()->json($errs, 500);
            }

            $email = trim($request->get('email'));
            $user = User::where('email',$email)->first();
            if($user){
                //Password Reset is Active
                if($user->is_pwd_reset){
                    return response()
                        ->json([
                            'statusCode'=>550,
                            'statusMessage'=>"Use The Reset Password Token sent to ${email}",
                            'payload'=>[]], 200);
                }


                $token =strtoupper(substr(md5(rand()),0,8));
                $user->password_reset_token = $token;
                $user->is_pwd_reset = true;
                $user->save();
                //Send Token email
                $user->notify(new PasswordReset($token));
                return response()
                    ->json([
                        'statusCode'=>0,
                        'statusMessage'=>"Reset Password Email Sent Successfully to ${email}",
                        'payload'=>[]], 200);
            }else{
                return response()->json(['statusCode'=>1,'statusMessage'=>"No account exist for ${email}"], 500);
            }
        }



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
