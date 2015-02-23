<?php

/*
 * TrackerValue Model
 * The model name must be the same name of the table but in the singular
 * Else : protected $table = 'name_table'
 */
namespace MyDropper\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class TrackerStore extends Eloquent
{

    protected $table = 'trackstores';
    protected $guarded = array('id');

    public function stores()
    {
        return $this->belongsTo('MyDropper\Models\Store', 'store_id');
    }

    public function users()
    {
        return $this->belongsTo('MyDropper\Models\User', 'user_id');
    }

}