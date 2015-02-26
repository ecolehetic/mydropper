<?php

/*
 * User Model
 * The model name must be the same name of the table but in the singular
 * Else : protected $table = 'name_table'
 */
namespace MyDropper\models;

use GUMP;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class User
 * @package MyDropper\Models
 */
class User extends Eloquent
{

    protected $table = 'users';
    protected $guarded = array('id');

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stores()
    {
        return $this->hasMany('MyDropper\models\Store');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany('MyDropper\models\Category');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function urls()
    {
        return $this->hasMany('MyDropper\models\Url');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trackersStores()
    {
        return $this->hasMany('MyDropper\models\TrackerStore');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trackersUrls()
    {
        return $this->hasMany('MyDropper\models\TrackerUrl');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function roles()
    {
        return $this->belongsTo('MyDropper\models\Role', 'role_id');
    }

    /**
     * Do cascading deletion
     * @return parent
     * @throws \Exception
     */
    public function delete()
    {
        foreach ($this->stores as $value) {
            $value->delete();
        }
        foreach ($this->categories as $value) {
            $value->delete();
        }
        foreach ($this->urls as $value) {
            $value->delete();
        }
        foreach ($this->trackersStores as $value) {
            $value->delete();
        }
        foreach ($this->trackersUrls as $value) {
            $value->delete();
        }
        return parent::delete();
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
     * @param array $formData
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
     * @param array $formData
     * @param int   $id
     *
     * @return mixed
     */
    public static function checkAdminEdit($formData, $id)
    {
        $is_valid = true;

        if (!self::isUniqueUser($formData['username'], $id)) {
            if ($is_valid === true) {
                $is_valid = [];
            }
            array_push($is_valid, 'This username is already taken');
        }
        if (!self::isUniqueEmail($formData['mail'], $id)) {
            if ($is_valid === true) {
                $is_valid = [];
            }
            array_push($is_valid, 'This email is already taken');
        }
        return $is_valid;
    }



    /**
     * Check username availability
     *
     * @param $username
     *
     * @return bool
     */
    private static function isUniqueUser($username, $id=0)
    {
        $user = self::where('username', '=', $username)->first();
        if ($user !== null && $user->id !== $id) {
            return false;
        }
        return true;
    }

    /**
     *Check email availability
     * @param $email
     * @return bool
     */
    private static function isUniqueEmail($email, $id=0)
    {
        $user = self::where('mail', '=', $email)->first();
        if ($user !== null && $user->id !== $id) {
            return false;
        }
        return true;
    }
}
