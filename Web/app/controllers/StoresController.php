<?php

namespace APP\CONTROLLERS;

use APP\HELPERS\GoogleUrlApi;
use APP\MODELS\Store as Store;
use APP\MODELS\Category as Category;
use APP\MODELS\TrackerUrl;

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
            $trackUrl = $this->f3->get('POST.trackedLink');

            if ($is_valid) {

                $post = $this->f3->get('POST');
                $store = Store::create([
                    'user_id'     => $user->id,
                    'label'       => $post['label'],
                    'descript'    => $post['descript'],
                    'category_id' => $post['category_id']
                ]);

                // If user want trackUrl
                if (!empty($trackUrl)) {
                    $googleUrl = new GoogleUrlApi();

                    TrackerUrl::create([
                        'user_id'   => $user->id,
                        'store_id'  => $store->id,
                        'short_url' => $googleUrl->shorten($post['descript']),
                    ]);

                    // Define in the store (is_shorter) to 1
                    $store = Store::find($store->id);
                    $store->is_shorter = 1;
                    $store->save();

                    $this->fMessage->set('Store added with a shorterLink.'); // TODO Change text
                }
                else{
                    $this->fMessage->set('Store added.');
                }

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
     * GET /stores/delete/@id/@cat_id
     */
    public function delete()
    {
        $user = $this->need->logged('/users/login')->user()->execute();

        $id = (int)($this->f3->get('PARAMS.id'));
        $cat_id = (int)($this->f3->get('PARAMS.cat_id'));

        if (!Store::isOwnedBy($id, $user->id)) {
            $this->f3->reroute('/history', true);
        }
        if (Store::destroy($id) > 0) {
            $this->fMessage->set('Delete complete', 'error');
            $this->f3->reroute('/category/' . $cat_id, true);
        } else {
            $this->fMessage->set('Error on delete', 'alert');
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