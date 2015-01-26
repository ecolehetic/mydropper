<?php

/*
 * Store Model
 * The model name must be the same name of the table but in the singular
 * Else : protected $table = 'name_table'
 */
namespace APP\MODELS;

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Address extends Eloquent
{

    protected $table = 'addresses';

    public function users()
    {
        return $this->belongsTo('\APP\MODELS\User', 'user_id');
    }

}