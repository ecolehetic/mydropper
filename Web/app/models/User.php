<?php

/*
 * User Model
 * The model name must be the same name of the table but in the singular
 * Else : protected $table = 'name_table'
 */
namespace APP\MODELS;

use GUMP as GUMP;
use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent
{

    protected $table = 'users';
    protected $guarded = array('id');

    public function stores()
    {
        return $this->hasMany('\APP\MODELS\Store');
    }

    public function urls()
    {
        return $this->hasMany('\APP\MODELS\Url');
    }

    public function categories()
    {
        return $this->hasMany('\APP\MODELS\Category');
    }

    public function roles()
    {
        return $this->belongsTo('\APP\MODELS\Role', 'role_id', 'id');
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
            'username'   => 'required|max_len,50',
            'firstname'  => 'required|max_len,45',
            'lastname'   => 'required|max_len,45',
            'mail'       => 'required|valid_email',
            'birthday'   => 'required|date',
            'password_1' => 'required|min_len,10',
            'password_2' => 'required|min_len,10',
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
     * Check if data seed in form are good
     *
     * @param array $formData
     *
     * @return mixed
     */
    public static function checkFormConnect($formData)
    {
        $is_valid = GUMP::is_valid($formData, array(
            'username' => 'required',
            'password' => 'required'
        ));

        return $is_valid;
    }

}