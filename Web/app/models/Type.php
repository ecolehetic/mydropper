<?php

/*
 * Type Model
 * The model name must be the same name of the table but in the singular
 * Else : protected $table = 'name_table'
 */
namespace APP\MODELS;

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Type extends Eloquent
{

    protected $table = 'types';

    public function stores()
    {
        return $this->hasMany('\APP\MODELS\Store', 'type_id');
    }

}