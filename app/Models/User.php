<?php

namespace App\Models;

use Hash;
use Laravel\Passport\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, Notifiable;

    /**
     * Name of the model table
     * 
     * @var string
     */
    protected $table = 'Users';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'first_name', 'last_name'
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
     * @param string 
     * @param string 
     * @param string 
     * @param mixed 
     * @param mixed 
     * @return App\Models\User
     */
    public static function withData(string $userName, string $email, string $password, $firstName, $lastName)
    {
        $instance = new self();
        $instance->username = $userName;
        $instance->email = $email;
        $instance->password = Hash::make($password);
        $instance->first_name = $firstName;
        $instance->last_name = $lastName;

        return $instance;
    }


    /**
     * @param string 
     * @param string 
     * @param string 
     * @param mixed 
     * @param mixed 
     * @return mixed
     */
    public static function createAndSave(string $userName, string $email, string $password, $firstName, $lastName)
    {
        $newUser = User::withData($userName, $email, $password, $firstName, $lastName);

        try {
            if(!User::existsWithEmail($email) && !User::existsWithUserName($userName))
            {
                $newUser->save();
                return true;
            }
            else
            {
                return 'user_already_exists';
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
    public static function deleteUser(string $userName)
    {
        try {
            $user = User::firstByUserName($userName);
            if(null !== $user)
            {
                $user->delete();
                return true;
            }
            else
            {
                return 'user_not_found';
            }
        }
        catch(PDOException $e) {
            return $e->getMessage();
        }
    }


    /**
     * @param array 
     * @return mixed
     */
    public static function updateUser(array $params)
    {
        $userName = $params['username'];
        $email = isset($params['email']) ? $params['email'] : '';
        $firstName = isset($params['first_name']) ? $params['first_name'] : '';
        $lastName = isset($params['last_name']) ? $params['last_name'] : '';

        $shouldUpdateEmail = !empty($email);
        $shouldUpdateFirstName = !empty($firstName);
        $shouldUpdateLastName = !empty($lastName);

        try {
            if($shouldUpdateEmail)
            {
                $checkUser = User::firstByEmail($email);
                if(null !== $checkUser)
                {
                    return 'email_already_taken';
                }
            }

            $user = User::firstByUserName($userName);
            if(null !== $user)
            {
                if($shouldUpdateEmail) {
                    $user->email = $email;
                }
                if($shouldUpdateFirstName) {
                    $user->first_name = $firstName;
                }
                if($shouldUpdateLastName) {
                    $user->last_name = $lastName;
                }
                
                $user->save();
                return true;
            }
            else
            {
                return 'user_not_found';
            }
        }
        catch(PDOException $e) {
            return $e->getMessage();
        }
    }


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    /**
     * Returns User's ID
     * 
     * @return string
     */
    public function getID()
    {
        return $this->id;
    }


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
     * Returns User's password
     * 
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
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

    /**
     * Returns first user by username
     * 
     * @param string
     * @return App\Models\User
     */
    public static function firstByUserName(string $userName)
    {
        return User::where('username', $userName)->first();
    }

    /**
     * Returns first user by email
     * 
     * @param string
     * @return App\Models\User
     */
    public static function firstByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    /**
     * Checks whether User already exists
     * 
     * @param string
     * @return bool
     */
    public static function existsWithUsername(string $userName)
    {
        return (null !== User::firstByUserName($userName));
    }

    /**
     * Checks whether User already exists
     * 
     * @param string
     * @return bool
     */
    public static function existsWithEmail(string $email)
    {
        return (null !== User::firstByEmail($email));
    }
}
