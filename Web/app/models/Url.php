<?php

/*
 * Url Model
 * The model name must be the same name of the table but in the singular
 * Else : protected $table = 'name_table'
 */
namespace APP\MODELS;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Url extends Eloquent
{
    protected $table = 'urls';

    public function trackers()
    {
        return $this->hasMany('APP\MODELS\TrackerUrl', 'url_id');
    }

    public function users()
    {
        return $this->belongsTo('APP\MODELS\User', 'user_id');
    }
}