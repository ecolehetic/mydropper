<?php

/*
 * TrackerUrl Model
 * The model name must be the same name of the table but in the singular
 * Else : protected $table = 'name_table'
 */
namespace MyDropper\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class TrackerUrl
 * @package MyDropper\Models
 */
class TrackerUrl extends Eloquent
{

    protected $table = 'trackurls';
    protected $guarded = array('id');

    public function users()
    {
        return $this->belongsTo('MyDropper\Models\User', 'user_id');
    }

}