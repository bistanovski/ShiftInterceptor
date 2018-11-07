<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorReading extends Model
{
    /**
     * Name of the model table
     * 
     * @var string
     */
    protected $table = 'SensorReadings';

    /**
     * Primary key
     * 
     * @var string
     */
    protected $primaryKey = 'reading_id';

    /**
     * Define whether primary key is auto incremented
     * 
     * @var boolean
     */
    public $incrementing = true;

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
     * Returns parent Sensor
     * 
     * @return App\Models\Sensor
     */
    public function sensor()
    {
        return $this->belongsTo('App\Models\Sensor', 'sensor_id', 'id');
    }

    /**
     * Returns SensorReading's name
     * 
     * @return string
     */
    public function getReadingName()
    {
        return $this->reading_name;
    }

    /**
     * Returns SensorReading's type
     * 
     * @return string
     */
    public function getReadingType()
    {
        return $this->reading_type;
    }

    /**
     * Returns SensorReading's rendering type
     * 
     * @return string
     */
    public function getRenderingType()
    {
        return $this->rendering_type;
    }
}
