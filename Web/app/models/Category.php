<?php

/*
 * Tag Model
 * The model name must be the same name of the table but in the singular
 * Else : protected $table = 'name_table'
 */
namespace APP\MODELS;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Category extends Eloquent
{

    protected $table = 'categories';

    public function users()
    {
        return $this->belongsTo('\APP\MODELS\User', 'user_id');
    }

    public function stores()
    {
        return $this->hasMany('\APP\MODELS\Store');
    }
}