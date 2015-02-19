<?php

/*
 * Tag Model
 * The model name must be the same name of the table but in the singular
 * Else : protected $table = 'name_table'
 */
namespace APP\MODELS;

use GUMP;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Category extends Eloquent
{

    protected $table = 'categories';
    protected $guarded = array('id');

    public function users()
    {
        return $this->belongsTo('\APP\MODELS\User', 'user_id');
    }

    public function stores()
    {
        return $this->hasMany('\APP\MODELS\Store');
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
        if($cat_id !== null && $user_id !== null){
            $cat = Category::find($cat_id);
            if($cat->user_id == $user_id){
                return true;
            }else{
                return false;
            }
        }else{
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