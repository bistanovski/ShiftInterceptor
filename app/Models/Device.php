<?php

namespace App\Models;

use App\Models\Sensor;
use App\Models\SensorReading;
use Illuminate\Database\Eloquent\Model;

abstract class DeviceType 
{
    const DESKTOP = 'DESKTOP';
    const MOBILE = 'MOBILE';
    const EMBEDDED = 'EMBEDDED';
}

class Device extends Model
{
    /**
     * Name of the model table
     * 
     * @var string
     */
    protected $table = 'Devices';

    /**
     * Primary key
     * 
     * @var string
     */
    protected $primaryKey = 'device_id';

    /**
     * Primary key type
     * 
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Define whether primary key is auto incremented
     * 
     * @var boolean
     */
    public $incrementing = false;

    /**
     * Define which properties should not be mass assignable
     * 
     * @var array
     */
    protected $guarded = [];


    /**
     * Returns Device's UUID
     * 
     * @return string
     */
    public function getDeviceID()
    {
        return $this->device_id;
    }

    /**
     * Returns Device's name
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns Device's type
     * 
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns Device's operating system
     * 
     * @return string
     */
    public function getOS()
    {
        return $this->operating_system;
    }

    /**
     * Returns version of Device's operating system
     * 
     * @return string
     */
    public function getOSVersion()
    {
        return $this->os_version;
    }

    /**
     * Returns number of sensors installed on Device
     * 
     * @return integer
     */
    public function getNumOfSensors()
    {
        return $this->number_of_sensors;
    }

    /**
     * @param string 
     * @param string 
     * @param string 
     * @param string 
     * @param string 
     * @param int 
     * @return App\Models\Device
     */
    public static function withData(string $deviceID, string $deviceName, 
                                    string $deviceType, string $operatingSystem, 
                                    string $osVersion, int $numOfSensors)
    {
        $instance = new self();
        $instance->device_id = $deviceID;
        $instance->name = $deviceName;
        $instance->type = $deviceType;
        $instance->operating_system = $operatingSystem;
        $instance->os_version = $osVersion;
        $instance->number_of_sensors = $numOfSensors;

        return $instance;
    }

    /**
     * @param array 
     * @return mixed
     */
    public static function createAndSave(array $params)
    {
        $newDevice = Device::withData($params['device_id'], $params['name'], 
                                  $params['type'], $params['operating_system'],
                                  $params['os_version'], $params['number_of_sensors']);

        try {
            if(!Device::existsWithDeviceID($params['device_id']))
            {
                $newDevice->save();

                $sensorsList = $params['sensors'];
                foreach ($sensorsList as $sensorParams) 
                {
                    $sensor = $newDevice->sensors()->create([
                            'sensor_name' => $sensorParams['sensor_name'], 
                            'number_of_readings' => $sensorParams['number_of_readings']
                        ]);
                    if(null !== $sensor)
                    {
                        $sensorReadingsList = $sensorParams['sensor_readings'];
                        foreach($sensorReadingsList as $sensorReadingParams)
                        {
                            $sensorReading = $sensor->sensorReadings()->create([
                                'reading_name' => $sensorReadingParams['reading_name'],
                                'reading_type' => $sensorReadingParams['reading_type'],
                                'rendering_type' => $sensorReadingParams['rendering_type']
                            ]);
                        }
                    }
                    else
                    {
                        return 'Registering sensor failed';
                    }
                }

                return true;
            }
            else
            {
                return 'device_already_exists';
            }
        }
        catch(PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param string 
     * @return mixed
     */
    public static function deleteDevice(string $deviceID)
    {
        try {
            $device = Device::firstByDeviceID($deviceID);
            if(null !== $device)
            {
                $device->delete();
                return true;
            }
            else
            {
                return 'device_not_found';
            }
        }
        catch(PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Checks whether Device already exists
     * 
     * @param string
     * @return bool
     */
    public static function existsWithDeviceID(string $deviceID)
    {
        return (null !== Device::firstByDeviceID($deviceID));
    }

    /**
     * Returns first Device by deviceID
     * 
     * @param string
     * @return App\Models\Device
     */
    public static function firstByDeviceID(string $deviceID)
    {
        return Device::where('device_id', $deviceID)->first();
    }

    /**
     * Returns registrations containing current Device
     * 
     * @return App\Models\UserDeviceRegistration
     */
    public function deviceRegistrations()
    {
        return $this->hasMany('App\Models\UserDeviceRegistration', 'device_id', 'device_id');
    }

    /**
     * Returns Device's Sensors
     * 
     * @return App\Models\Sensor
     */
    public function sensors()
    {
        return $this->hasMany('App\Models\Sensor', 'device_id', 'device_id');
    }

    /**
     * Returns Device's settings
     * 
     * @return App\Models\Settings
     */
    public function settings()
    {
        return $this->hasMany('App\Models\Settings', 'device_id', 'device_id');
    }
}
