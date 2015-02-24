<?php

/*
 * Url Model
 * The model name must be the same name of the table but in the singular
 * Else : protected $table = 'name_table'
 */
namespace MyDropper\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes as SoftDeletes;

/**
 * Class Url
 * @package MyDropper\Models
 */
class Url extends Eloquent
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = array('id');
    protected $table = 'urls';

    public function users()
    {
        return $this->belongsTo('MyDropper\Models\User', 'user_id');
    }

    /**
     * Generate Token for UrlShorter
     */
    public static function generateToken()
    {
        do {
            $token = substr(uniqid('', true), -5);

            $url = Url::where('token', '=', $token)->count();
        } while ($url > 0);

        return $token;
    }
}
