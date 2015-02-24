<?php

/*
 * Role Model
 * The model name must be the same name of the table but in the singular
 * Else : protected $table = 'name_table'
 */
namespace MyDropper\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Role
 * @package MyDropper\Models
 */
class Role extends Eloquent
{

    protected $table = 'roles';

    public function users()
    {
        return $this->hasMany('MyDropper\Models\User');
    }
}
