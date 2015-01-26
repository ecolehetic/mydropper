<?php

/*
 * User Model
 * The model name must be the same name of the table but in the singular
 * Else : protected $table = 'name_table'
 */
namespace APP\MODELS;

use \Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent
{

    protected $table = 'users';

    public function stores(){
        return $this->hasMany('\APP\MODELS\Store');
    }

    public function addresses(){
        return $this->hasMany('\APP\MODELS\Address');
    }

    public function urls(){
        return $this->hasMany('\APP\MODELS\Url');
    }

    public function values(){
        return $this->hasMany('\APP\MODELS\Value');
    }

    public function tags(){
        return $this->hasMany('\APP\MODELS\Tag');
    }

    public function roles()
    {
        return $this->belongsTo('\APP\MODELS\Role', 'role_id', 'id');
    }

}