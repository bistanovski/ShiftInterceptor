<?php

namespace App\Http\Controllers;

use App\Models\User;
use Validator, DB, Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
  
  /**
   * Get all Users
   */
  public function getUsers(Request $request)
  {
    return User::all();
  }


  /**
   * Generate personal token for User's Device
   * 
   * @param Request
   * @return \Illuminate\Http\JsonResponse
   */
  public function createTokenForDevice(Request $request)
  {
    $params = $request->only('username', 'password', 'device_id');

    $rules = [
      'username' => 'required|string|max:255',
      'device_id' => 'required|string|min:40|max:40',
      'password' => 'required|string|min:6'
    ];

    $validator = Validator::make($params, $rules);
    
    if($validator->fails()) {
        return response()->webApi(['error' => $validator->messages()], 401);
    }

    $user = User::firstByUserName($params['username']);
    if(null !== $user)
    {
      if (Hash::check($params['password'], $user->getPassword()))
      {
        $tokenName = 'token_' . $params['device_id'];
        $token = $user->createToken($tokenName)->accessToken;
        return response()->webApi(['personal_token' => $token]);
      }
      else
      {
        return response()->webApi(['error' => 'authentication_failed'], 401);
      }
    }
    else
    {
      return response()->webApi(['error' => 'user_not_found'], 401);
    }
  }


  /**
   * Create new User
   * 
   * @param Request
   * @return \Illuminate\Http\JsonResponse
   */
  public function createUser(Request $request)
  {
    $credentials = $request->only('username', 'email', 'password');
        
    $rules = [
      'username' => 'required|string|max:255|unique:Users', 
      'email' => 'required|string|email|max:255|unique:Users',
      'password' => 'required|string|min:6'
    ];
    
    $validator = Validator::make($credentials, $rules);
    
    if($validator->fails()) {
        return response()->webApi(['error' => $validator->messages()], 401);
    }

    $result = User::createAndSave($request->username, $request->email, $request->password);

    if(true === $result) {
      return response()->webApi(['Successful registration!'], 201);
    }

    return response()->webApi(['error' => $result], 401);
  }


  /**
   * Update User
   * 
   * @param Request
   * @return \Illuminate\Http\JsonResponse
   */
  public function updateUser(Request $request)
  {

  }

}
