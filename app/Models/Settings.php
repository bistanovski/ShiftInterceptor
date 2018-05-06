<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    /**
     * Name of the model table
     * 
     * @var string
     */
    protected $table = 'Settings';

    /**
     * Primary key
     * 
     * @var string
     */
    protected $primaryKey = 'setting_id';

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
     * Returns User's username of current setting
     * 
     * @return string
     */
    public function getUserName()
    {
        return $this->username;
    }

    /**
     * Returns parent User
     * 
     * @return App\Models\User
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'username', 'username');
    }

    /**
     * Returns Device's UUID for current setting
     * 
     * @return string
     */
    public function getDeviceID()
    {
        return $this->device_id;
    }

    /**
     * Return parent Device
     * 
     * @return App\Models\Device
     */
    public function device()
    {
        return $this->belongsTo('App\Models\Device', 'device_id', 'device_id');
    }

    /**
     * Returns key for current setting
     * 
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Returns type for current setting
     * 
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns value for current setting
     * 
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
