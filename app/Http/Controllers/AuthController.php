<?php

namespace App\Http\Controllers;

use JWTAuth;
use Validator;

use Illuminate\Mail\Message;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{

    /**
     * API Login, on success return JWT Auth token
     *
     * @param Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $rememberUser = (boolean)$request->input('remember_me');
        
        $rules = [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ];

        $validator = Validator::make($credentials, $rules);
        if($validator->fails()) {
            return response()->webApi(['error' => $validator->messages()], 404);
        }
                
        try {
            if(! $token = JWTAuth::attempt($credentials, $rememberUser)) 
            {
                return response()->webApi(['error' => 'Invalid credentials!'], 401);
            }
        } 
        catch (JWTException $e) {
            return response()->webApi(['error' => 'Failed to login, please try again.'], 500);
        }
        
        return response()->webApi(['token' => $token, 'remember' => $rememberUser]);
    }


    /**
     * Log out
     * Invalidate the token, so user cannot use it anymore
     *
     * @param Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request) {
        $this->validate($request, ['token' => 'required']);
        
        try {
            JWTAuth::invalidate($request->input('token'));
            return response()->webApi(['You have successfully logged out.']);
        } 
        catch (JWTException $e) {
            return response()->webApi(['error' => 'Failed to logout, please try again.'], 500);
        }
    }

}