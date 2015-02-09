<?php

/*
 * Store Model
 * The model name must be the same name of the table but in the singular
 * Else : protected $table = 'name_table'
 */
namespace APP\MODELS;

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Store extends Eloquent
{

    protected $table = 'stores';

    public function users()
    {
        return $this->belongsTo('\APP\MODELS\User', 'user_id');
    }

    public function categories()
    {
        return $this->belongsTo('\APP\MODELS\Category', 'store_id');
    }

}