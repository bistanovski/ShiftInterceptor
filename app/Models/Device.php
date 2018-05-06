<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    public function getID()
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
