<?php

namespace App\Validations;

abstract class UserValidations 
{
  const paramsByFunction = [
    'createTokenForDevice' => ['username', 'password', 'device_id'],
    'createUser' => ['username', 'email', 'password'],
    'updateUser' => ['username', 'email', 'first_name', 'last_name'],
    'deleteUser' => ['username']
  ];
  
  const rulesByFunction = [
    'createTokenForDevice' => [
      'username' => 'required|string|max:255',
      'password' => 'required|string|min:6',
      'device_id' => 'required|string|min:40|max:40'
    ],
    'createUser' => [
      'username' => 'required|string|max:255|unique:Users', 
      'email' => 'required|string|email|max:255|unique:Users',
      'password' => 'required|string|min:6',
      'first_name' => 'nullable|string|max:255',
      'last_name' => 'nullable|string|max:255'
    ],
    'updateUser' => [
      'username' => 'required|string|max:255',
      'email' => 'nullable|string|email|max:255',
      'first_name' => 'nullable|string|max:255',
      'last_name' => 'nullable|string|max:255'
    ],
    'deleteUser' => [
      'username' => 'required|string|max:255'
    ]
  ];
}