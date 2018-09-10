<?php

namespace App\Http\Controllers;

use App\Models\User;
use Validator, DB, Hash;
use Illuminate\Http\Request;

use App\Validations\UserValidations;

class UserController extends Controller
{

  /**
   * Get all Users
   * 
   * @param Request
   * @return \Illuminate\Http\JsonResponse
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
    $params = $request->only(UserValidations::paramsByFunction[__FUNCTION__]);

    $validateStatus = $this->_validateUserParams($params, UserValidations::rulesByFunction[__FUNCTION__]);
    if(true !== $validateStatus)
    {
      return response()->webApi(['error' => $validateStatus], 401);
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
    $params = $request->only(UserValidations::paramsByFunction[__FUNCTION__]);
        
    $validateStatus = $this->_validateUserParams($params, UserValidations::rulesByFunction[__FUNCTION__]);
    if(true !== $validateStatus)
    {
      return response()->webApi(['error' => $validateStatus], 401);
    }

    $result = User::createAndSave($params['username'], $params['email'], $params['password'], 
                                  isset($params['first_name']) ? $params['first_name'] : null, 
                                  isset($params['last_name']) ? $params['last_name'] : null);

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
    $params = $request->only(UserValidations::paramsByFunction[__FUNCTION__]);

    $validateStatus = $this->_validateUserParams($params, UserValidations::rulesByFunction[__FUNCTION__]);
    if(true !== $validateStatus)
    {
      return response()->webApi(['error' => $validateStatus], 401);
    }

    $result = User::updateUser($params);

    if(true === $result) {
      return response()->webApi(['Successful update!'], 201);
    }

    return response()->webApi(['error' => $result], 401);
  }

  /**
   * Delete User
   * 
   * @param Request
   * @return \Illuminate\Http\JsonResponse
   */
  public function deleteUser(Request $request)
  {
    $params = $request->only(UserValidations::paramsByFunction[__FUNCTION__]);

    $validateStatus = $this->_validateUserParams($params, UserValidations::rulesByFunction[__FUNCTION__]);
    if(true !== $validateStatus)
    {
      return response()->webApi(['error' => $validateStatus], 401);
    }

    $result = User::deleteUser($params['username']);

    if(true === $result) {
      return response()->webApi(['Successful deletion!'], 201);
    }

    return response()->webApi(['error' => $result], 401);
  }

}
