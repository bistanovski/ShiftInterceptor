<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Name of the model table
     * 
     * @var string
     */
    protected $table = 'Users';

    /**
     * Primary key
     * 
     * @var string
     */
    protected $primaryKey = 'username';

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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'first_name', 'last_name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];


    /**
     * Returns username
     * 
     * @return string
     */
    public function getUserName()
    {
        return $this->username;
    }

    /**
     * Returns User's email
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Returns User's first name
     * 
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Returns User's last name
     * 
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Returns User's device registrations
     * 
     * @return App\Models\UserDeviceRegistration
     */
    public function deviceRegistrations()
    {
        return $this->hasMany('App\Models\UserDeviceRegistration', 'username', 'username');
    }

    /**
     * Returns User's settings
     * 
     * @return App\Models\Settings
     */
    public function settings()
    {
        return $this->hasMany('App\Models\Settings', 'username', 'username');
    }
}
