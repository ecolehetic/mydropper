<?php

/*
 * Role Model
 * The model name must be the same name of the table but in the singular
 * Else : protected $table = 'name_table'
 */
namespace APP\MODELS;

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Tag extends Eloquent
{

    protected $table = 'tags';

    public function stores()
    {
        return $this->belongsToMany('Store', 'tag_store', 'tag_id', 'store_id');
    }

}