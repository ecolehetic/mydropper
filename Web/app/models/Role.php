<?php

/*
 * Role Model
 * The model name must be the same name of the table but in the singular
 * Else : protected $table = 'name_table'
 */
namespace APP\MODELS;

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Role extends Eloquent
{

    protected $table = 'roles';

    public function users()
    {
        return $this->hasMany('\APP\MODELS\User');
    }

}