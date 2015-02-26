<?php

/*
 * TrackerValue Model
 * The model name must be the same name of the table but in the singular
 * Else : protected $table = 'name_table'
 */
namespace MyDropper\models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes as SoftDeletes;

/**
 * Class TrackerStore
 * @package MyDropper\Models
 */
class TrackerStore extends Eloquent
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'trackstores';
    protected $guarded = array('id');

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stores()
    {
        return $this->belongsTo('MyDropper\models\Store', 'store_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo('MyDropper\models\User', 'user_id');
    }
}
