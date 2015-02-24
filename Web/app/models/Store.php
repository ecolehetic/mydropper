<?php

/*
 * Store Model
 * The model name must be the same name of the table but in the singular
 * Else : protected $table = 'name_table'
 */
namespace MyDropper\Models;

use GUMP;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes as SoftDeletes;

/**
 * Class Store
 * @package MyDropper\Models
 */
class Store extends Eloquent
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'stores';
    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsTo('MyDropper\Models\User', 'user_id');
    }

    public function categories()
    {
        return $this->belongsTo('MyDropper\Models\Category', 'category_id');
    }

    public function trackerstores()
    {
        return $this->hasMany('MyDropper\Models\TrackerStore');
    }

    /**
     * Check if user owns a particular Store
     *
     * @param null $store_id
     * @param null $user_id
     * @return bool
     */
    public static function isOwnedBy($store_id = null, $user_id = null)
    {
        if ($store_id !== null && $user_id !== null) {
            $store = Store::find($store_id);
            if ($store !== null && $store->user_id == $user_id) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Check if data seed in Form are good
     *
     * @param array $formData
     *
     * @return mixed
     */
    public static function checkOnCreate($formData)
    {
        $is_valid = GUMP::is_valid($formData, array(
            'label'    => 'required|max_len,45',
            'descript' => 'required'
        ));

        return $is_valid;
    }

}