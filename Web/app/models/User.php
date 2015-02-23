<?php

/*
 * User Model
 * The model name must be the same name of the table but in the singular
 * Else : protected $table = 'name_table'
 */
namespace MyDropper\Models;

use GUMP;
use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent
{

    protected $table = 'users';
    protected $guarded = array('id');

    public function stores()
    {
        return $this->hasMany('MyDropper\Models\Store');
    }

    public function categories()
    {
        return $this->hasMany('MyDropper\Models\Category');
    }

    public function roles()
    {
        return $this->belongsTo('MyDropper\Models\Role', 'role_id');
    }

    /**
     * Check if data seed in Form are good
     *
     * @param array $formData
     *
     * @return mixed
     */
    public static function checkFormSubscribe($formData)
    {
        $is_valid = GUMP::is_valid($formData, array(
            'username'        => 'required|max_len,50',
            'firstname'       => 'required|max_len,45',
            'lastname'        => 'required|max_len,45',
            'mail'            => 'required|valid_email',
            'mail_pushbullet' => 'valid_email',
            'password_1'      => 'required|min_len,5',
            'password_2'      => 'required|min_len,5',
        ));

        if ($formData['password_1'] !== $formData['password_2']) {
            if ($is_valid === true) {
                $is_valid = [];
                array_push($is_valid, "The password must be the same");
            } else {
                array_push($is_valid, 'The password must be the same');
            }
        }

        return $is_valid;
    }

    /**
     * Check form
     *
     * @param $formData
     * @param array $rules
     *
     * @return string
     */
    public static function checkForm($formData, $rules)
    {
        $is_valid = GUMP::is_valid($formData, $rules);

        return $is_valid;
    }


    /**
     * Check Admin Form
     *
     * @param $formData
     * @param $rules
     * @return mixed
     */
    public static function checkAdminEdit($formData, $id)
    {
        $is_valid = true;

        if(!self::isUniqueUser($formData['username'], $id)){
            if($is_valid === true){
                $is_valid = [];
            }
            array_push($is_valid, 'This username is already taken');
        }
        if(!self::isUniqueEmail($formData['mail'], $id)){
            if($is_valid === true){
                $is_valid = [];
            }
            array_push($is_valid, 'This email is already taken');
        }
        return $is_valid;
    }



    /**
     * Check username availability
     * @param $username
     * @return bool
     */
    private static function isUniqueUser($username, $id=0){
        $user = self::where('username', '=', $username)->first();
        if($user !== null && $user->id !== $id){
            return false;
        }
        return true;
    }

    /**
     *Check email availability
     * @param $email
     * @return bool
     */
    private static function isUniqueEmail($email, $id=0){
        $user = self::where('mail', '=', $email)->first();
        if($user !== null && $user->id !== $id){
            return false;
        }
        return true;
    }

}