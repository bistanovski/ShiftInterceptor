<?php

namespace App\Validations;

abstract class DeviceValidations 
{
  const paramsByFunction = [
    'registerDevice' => ['user_name', 'device_id', 'name', 'type', 'operating_system', 'os_version', 'number_of_sensors', 'sensors'],
    'deleteDevice' => ['device_id']
  ];

  const rulesByFunction = [
    'registerDevice' => [
      'user_name' => 'required|string|max:255',
      'device_id' => 'required|string|min:40|max:40|unique:Devices', 
      'name' => 'required|string|max:255',
      'type' => 'required|in:DESKTOP,MOBILE,EMBEDDED',
      'operating_system' => 'required|string|max:255',
      'os_version' => 'required|string|max:50',
      'number_of_sensors' => 'required|integer',
      'sensors' => 'required|array',
      'sensors.*.sensor_name' => 'required|string|max:255',
      'sensors.*.number_of_readings' => 'required|integer',
      'sensors.*.sensor_readings' => 'required|array',
      'sensors.*.sensor_readings.*.reading_name' => 'required|string|max:255',
      'sensors.*.sensor_readings.*.reading_type' => 'required|string|max:255',
      'sensors.*.sensor_readings.*.rendering_type' => 'required|string|max:255'
    ],
    'deleteDevice' => [
      'device_id' => 'required|string|min:40|max:40'
    ]
  ];
}