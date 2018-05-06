<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDeviceRegistration extends Model
{
    /**
     * Name of the model table
     * 
     * @var string
     */
    protected $table = 'UserDeviceRegistrations';

    /**
     * Primary key
     * 
     * @var string
     */
    protected $primaryKey = 'registration_id';

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
     * Returns Register's UUID
     * 
     * @return string
     */
    public function getRegistrationID()
    {
        return $this->registration_id;
    }

    /**
     * Returns User's username
     * 
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
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
     * Returns the User that owns the Regiser
     * 
     * @return App\Models\User
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'username', 'username');
    }

    /**
     * Returns the Device that owns the Regiser
     * 
     * @return App\Models\Device
     */
    public function device()
    {
        return $this->belongsTo('App\Models\Device', 'device_id', 'device_id');
    }
}
