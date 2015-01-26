<?php

/*
 * Basic Exemple for Futur Models !
 * The model name must be the same name of the table but in the singular
 * Else : protected $table = 'name_table'
 */
namespace APP\MODELS;

use \Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent
{

    protected $table = 'users';

    public function roles()
    {
        return $this->belongsTo('APP\MODELS\Role', 'role_id', 'id');
    }

}