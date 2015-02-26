<?php

/*
 * Store Model
 * The model name must be the same name of the table but in the singular
 * Else : protected $table = 'name_table'
 */
namespace MyDropper\models;

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo('MyDropper\models\User', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categories()
    {
        return $this->belongsTo('MyDropper\models\Category', 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trackerstores()
    {
        return $this->hasMany('MyDropper\models\TrackerStore');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function urls()
    {
        return $this->hasMany('MyDropper\models\Url');
    }

    /**
     * Do cascading deletion
     * @return parent
     * @throws \Exception
     */
    public function delete()
    {
        foreach ($this->trackerstores as $value) {
            $value->delete();
        }
        foreach ($this->urls as $value) {
            $value->delete();
        }
        return parent::delete();
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
