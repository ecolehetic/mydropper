<?php

/*
 * TrackerValue Model
 * The model name must be the same name of the table but in the singular
 * Else : protected $table = 'name_table'
 */
namespace APP\MODELS;

use Illuminate\Database\Eloquent\Model as Eloquent;

class TrackerStore extends Eloquent
{

    protected $table = 'trackstores';

    public function stores()
    {
        return $this->belongsTo('\APP\MODELS\Store', 'store_id');
    }

    public function users()
    {
        return $this->belongsTo('\APP\MODELS\User', 'user_id');
    }

}