<?php

namespace APP\CONTROLLERS;

use APP\MODELS\Store as Store;
use APP\MODELS\Category as Category;

/**
 * Class StoresController
 * @package APP\CONTROLLERS
 */
class StoresController extends BaseController
{

    /**
     * POST /stores/create
     */
    public function create()
    {

        $user = $this->need->logged('/users/login')->user()->execute();

        $cat_id = $this->f3->get('POST.category_id');

        if (!Category::isOwnedBy($cat_id, $user->id)) {
            $this->f3->reroute('/history', true);
        }

        if ($this->f3->get('POST')) {
            $is_valid = Store::checkOnCreate($this->f3->get('POST'));

            if ($is_valid) {
                $post = $this->f3->get('POST');
                Store::create([
                    'user_id'     => $user->id,
                    'label'       => $post['label'],
                    'descript'    => $post['descript'],
                    'category_id' => $post['category_id']
                ]);
                $this->fMessage->set('Store added.');
                $this->f3->reroute('/history', true);
            }
        }

    }

    /**
     * GET|POST /stores/edit/@id
     */
    public function edit()
    {
        $user = $this->need->logged('/users/login')->user()->execute();

        $id = (int)($this->f3->get('PARAMS.id'));

        if (!Store::isOwnedBy($id, $user->id)) {
            $this->f3->reroute('/history', true);
        }

        if ($this->f3->get('POST')) {

            $post = $this->f3->get('POST');
            $store = Store::find($id);
            $store->label = $post['label'];
            $store->descript = $post['descript'];
            $store->save();

            $this->fMessage->set('Record Updated');
            $this->f3->reroute('/history', true);

        } else {
            $store = Store::find($id);
        }

        $this->render(true, [
            'values' => $store,
            'id'     => $id
        ]);


    }

    /**
     * GET /stores/delete/@id
     */
    public function delete()
    {
        $user = $this->need->logged('/users/login')->user()->execute();

        $id = (int)($this->f3->get('PARAMS.id'));

        if (!Store::isOwnedBy($id, $user->id)) {
            $this->f3->reroute('/history', true);
        }
        if (Store::destroy($id) > 0) {
            $this->fMessage->set('delete complete', 'error');
            $this->f3->reroute('/history', true);
        } else {
            $this->fMessage->set('error on delete', 'alert');
            $this->f3->reroute('/history', true);
        }
    }

    /**
     * GET /admin/stores/index
     */
    public function admin_index()
    {
        //list using Store::withTrashed()->get();

    }

}