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
     * Primary key
     * 
     * @var string
     */
    protected $primaryKey = 'sensor_name';

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
     * Returns parent Device
     * 
     * @return App\Models\Device
     */
    public function device()
    {
        return $this->belongsTo('App\Models\Device', 'device_id', 'device_id');
    }
}
