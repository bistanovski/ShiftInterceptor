<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    /**
     * Name of the model table
     * 
     * @var string
     */
    protected $table = 'Sensors';

    /**
     * Define which properties should not be mass assignable
     * 
     * @var array
     */
    protected $guarded = [];


    /**
     * Returns Sensor's name
     * 
     * @return string
     */
    public function getSensorName()
    {
        return $this->sensor_name;
    }

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
     * Returns Device's number of sensor readings
     * 
     * @return int
     */
    public function getNumberOfReadings()
    {
        return (int) $this->number_of_readings;
    }

    /**
     * @param string 
     * @param string 
     * @param int 
     * @return App\Models\Sensor
     */
    public static function withData(string $sensorName, string $deviceID, int $numOfReadings)
    {
        $instance = new self();
        $instance->sensor_name = $sensorName;
        $instance->device_id = $deviceID;
        $instance->number_of_readings = $numOfReadings;

        return $instance;
    }

    /**
     * @param string
     * @param array 
     * @return mixed
     */
    public static function createAndSave(string $deviceID, array $params)
    {
        $newSensor = Sensor::withData($params['sensor_name'], $deviceID, $params['number_of_readings']);
        try {
            if(!Sensor::existsWithDeviceIDAndName($deviceID, $params['sensor_name']))
            {
                $newSensor->save();
                return true;
            }
            else
            {
                return 'sensor_already_exists';
            }
        }
        catch(PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Checks whether Sensor already exists
     * 
     * @param string
     * @param string
     * @return bool
     */
    public static function existsWithDeviceIDAndName(string $deviceID, string $sensorName)
    {
        return (null !== Sensor::firstByDeviceIDAndName($deviceID, $sensorName));
    }

    /**
     * Returns first Sensor by deviceID, and deviceName
     * 
     * @param string
     * @param string
     * @return App\Models\Sensor
     */
    public static function firstByDeviceIDAndName(string $deviceID, string $sensorName)
    {
        return Sensor::where('device_id', $deviceID)->where('sensor_name', $sensorName)->first();
    }

    /**
     * Returns Sensors's readings
     * 
     * @return App\Models\SensorReading
     */
    public function sensorReadings()
    {
        return $this->hasMany('App\Models\SensorReading', 'sensor_id', 'id');
    }

    /**
     * Returns parent Device
     * 
     * @return App\Models\Device
     */
    public function device()
    {
        return $this->belongsTo('App\Models\Device', 'device_id', 'device_id');
    }
}
