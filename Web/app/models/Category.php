<?php

/*
 * Tag Model
 * The model name must be the same name of the table but in the singular
 * Else : protected $table = 'name_table'
 */
namespace MyDropper\Models;

use GUMP;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes as SoftDeletes;

/**
 * Class Category
 * @package MyDropper\Models
 */
class Category extends Eloquent
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'categories';
    protected $guarded = array('id');

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo('MyDropper\Models\User', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stores()
    {
        return $this->hasMany('MyDropper\Models\Store');
    }

    /**
     * Do cascading deletion
     * @return parent
     * @throws \Exception
     */
    public function delete(){
        foreach($this->stores as $value){
            $value->delete();
        }
        return parent::delete();
    }

    /**
     * Check if user owns a particular category
     *
     * @param null $cat_id
     * @param null $user_id
     * @return bool
     */
    public static function isOwnedBy($cat_id=null, $user_id=null)
    {
        if ($cat_id !== null && $user_id !== null) {
            $cat = Category::find($cat_id);
            if ($cat->user_id == $user_id) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Check form
     *
     * @param $formData
     * @param array $rules
     *
     * @return string
     */
    public static function checkForm($formData, $rules)
    {
        $is_valid = GUMP::is_valid($formData, $rules);

        return $is_valid;
    }
}
