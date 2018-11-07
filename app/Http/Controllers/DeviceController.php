<?php

namespace App\Http\Controllers;

use App\Models\{Device, User, UserDeviceRegistration};
use Illuminate\Http\Request;

use App\Validations\DeviceValidations;

class DeviceController extends Controller
{
  
  /**
   * Get all Devices
   * 
   * @param Request
   * @return \Illuminate\Http\JsonResponse
   */
  public function getDevices()
  {
    return Device::all();
  }

  /**
   * Get Device by device_id, together with Sensors and SensorReadings
   * 
   * @param Request
   * @return \Illuminate\Http\JsonResponse
   */
  public function getDeviceSensors(String $device_id)
  {
    $params = ['device_id' => $device_id];
    $validateStatus = $this->_validateUserParams($params, DeviceValidations::rulesByFunction[__FUNCTION__]);
    if(true !== $validateStatus)
    {
      return response()->webApi(['error' => $validateStatus], 401);
    }

    return Device::where('device_id', $device_id)->with('sensors.sensorReadings')->get();
  }

  /**
   * Register new Device
   * 
   * @param Request
   * @return \Illuminate\Http\JsonResponse
   */
  public function registerDevice(Request $request)
  {
    $params = $request->only(DeviceValidations::paramsByFunction[__FUNCTION__]);
    
    $validateStatus = $this->_validateUserParams($params, DeviceValidations::rulesByFunction[__FUNCTION__]);
    if(true !== $validateStatus)
    {
      return response()->webApi(['error' => $validateStatus], 401);
    }

    $user = User::firstByUserName($params['user_name']);
    if($user === null)
    {
      return response()->webApi(['error' => 'Target user does not exist!'], 401);
    }

    $result = Device::createAndSave($params);

    if(true === $result) {
      $device = Device::firstByDeviceID($params['device_id']);
      $deviceRegistrationResult = UserDeviceRegistration::saveWithModels($user, $device);
      if(true === $deviceRegistrationResult)
      {
        return response()->webApi(['Successful registration!'], 201);
      }

      return response()->webApi(['error' => $deviceRegistrationResult], 401);
    }

    return response()->webApi(['error' => $result], 401);
  }


  /**
   * Delete Device
   * 
   * @param Request
   * @return \Illuminate\Http\JsonResponse
   */
  public function deleteDevice(Request $request)
  {
    $params = $request->only(DeviceValidations::paramsByFunction[__FUNCTION__]);
    
    $validateStatus = $this->_validateUserParams($params, DeviceValidations::rulesByFunction[__FUNCTION__]);
    if(true !== $validateStatus)
    {
      return response()->webApi(['error' => $validateStatus], 401);
    }

    $result = Device::deleteDevice($params['device_id']);

    if(true === $result) {
      return response()->webApi(['Successful deletion!'], 201);
    }

    return response()->webApi(['error' => $result], 401);

  }
  
}
