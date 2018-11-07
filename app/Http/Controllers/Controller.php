<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

   /**
   * Validate provided parameters based on provided rules
   * 
   * @param array
   * @param array
   * @return mixed
   */
  protected function _validateUserParams($params, $rules)
  {
    $validator = Validator::make($params, $rules);
    if($validator->fails())
    {
      return $validator->messages();
    }
    else
    {
      return true;
    }
  }
  
}
