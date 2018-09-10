<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;

class SettingsController extends Controller
{
  /**
   * Get all Settings
   * 
   * @param Request
   * @return \Illuminate\Http\JsonResponse
   */
  public function getSettings(Request $request)
  {
    return Settings::all();
  }
}
