<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserDeviceRegistration;

class DeviceRegistrationsController extends Controller
{
    /**
   * Get all Registrations, together with Users and Devices
   * 
   * @param Request
   * @return \Illuminate\Http\JsonResponse
   */
  public function getRegistrations(Request $request)
  {
    return UserDeviceRegistration::with(['user', 'device'])->get();
  }
}
