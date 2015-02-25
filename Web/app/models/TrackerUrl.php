<?php

/*
 * TrackerUrl Model
 * The model name must be the same name of the table but in the singular
 * Else : protected $table = 'name_table'
 */
namespace MyDropper\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes as SoftDeletes;

/**
 * Class TrackerUrl
 * @package MyDropper\Models
 */
class TrackerUrl extends Eloquent
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'trackurls';
    protected $guarded = array('id');

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo('MyDropper\Models\User', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function urls()
    {
        return $this->belongsTo('MyDropper\Models\Url', 'url_id');
    }
}
