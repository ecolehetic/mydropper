<?php

namespace MyDropper\Helpers;

use MyDropper\Models\Category;
use MyDropper\Models\Role;
use MyDropper\Models\Store;
use MyDropper\Models\TrackerStore;
use MyDropper\Models\TrackerUrl;
use MyDropper\Models\User;

class Removal extends BaseHelper
{
    private $is_soft = true;
    private $keys =
        [
            'Category' => 'category_id',
            'Role' => 'role_id',
            'Store' => 'store_id',
            'TrackerStore' => 'trackstore_id',
            'TrackerUrl' => 'trackurl_id',
            'Url' => 'url_id',
            'User' => 'user_id'
        ];
    private $id;
    private $fromModel;
    private $killKey;

    public function __construct($id = 0, $fromModel = '')
    {
        parent::__construct();
        $this->id = $id;
        $this->fromModel = $fromModel;
        $this->killKey = $this->keys[$fromModel];
    }

    /**
     * Manage cascading delete by softness
     *
     * @param array $toModels
     * @param bool $soft
     */
    public function cascade($toModels = array(), $soft = true)
    {
        $this->is_soft = $soft;
        if (count($toModels) > 0) {
            foreach ($toModels as $modelName) {
                $this->kill($modelName);
            }
        }
    }


    /**
     * Unlink datas when remove related Model
     *
     * @param $modelName
     */
    private function kill($modelName)
    {
        switch ($modelName) {
            case 'Category' :
                if ($this->is_soft) {
                    Category::where($this->killKey, '=', $this->id)->update(['deleted_at' => time()]);
                } else {
                    Category::where($this->killKey, '=', $this->id)->update([$this->killKey => null, 'deleted_at' => time()]);
                }
                break;
            case 'Role':
                if ($this->is_soft) {
                    Role::where($this->killKey, '=', $this->id)->update(['deleted_at' => time()]);
                } else {
                    Role::where($this->killKey, '=', $this->id)->update([$this->killKey => null]);
                }
                break;
            case 'Store':
                if ($this->is_soft) {
                    Store::where($this->killKey, '=', $this->id)->update(['deleted_at' => time()]);
                } else {
                    Store::where($this->killKey, '=', $this->id)->update([$this->killKey => null, 'deleted_at' => time()]);
                }
                break;
            case 'TrackerStore':
                if ($this->is_soft) {
                    TrackerStore::where($this->killKey, '=', $this->id)->update(['deleted_at' => time()]);
                } else {
                    TrackerStore::where($this->killKey, '=', $this->id)->update([$this->killKey => null, 'deleted_at' => time()]);
                }
                break;
            case 'TrackerUrl':
                if ($this->is_soft) {
                    TrackerUrl::where($this->killKey, '=', $this->id)->update(['deleted_at' => time()]);
                } else {
                    TrackerUrl::where($this->killKey, '=', $this->id)->update([$this->killKey => null]);
                }
                break;
            case 'Url':
                if ($this->is_soft) {
                    Url::where($this->killKey, '=', $this->id)->update(['deleted_at' => time()]);
                } else {
                    Url::where($this->killKey, '=', $this->id)->update([$this->killKey => null, 'deleted_at' => time()]);
                }
                break;
            case 'User':
                if ($this->is_soft) {
                    //                    NO CASE
                } else {
                    //                    NO CASE
                }
                break;
        }
    }
}
