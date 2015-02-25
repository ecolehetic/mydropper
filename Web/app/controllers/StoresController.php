<?php

namespace MyDropper\Controllers;

use MyDropper\Models\Store;
use MyDropper\Models\Category;
use MyDropper\Models\Url;
use MyDropper\Models\User;

/**
 * Class StoresController
 * @package MyDropper\Controllers
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
            $beNotice = $this->f3->get('POST.pushbullet');

            if ($is_valid) {
                
                $post         = $this->f3->get('POST');
                $preventStore = Store::where('label', '=', $post['label'])->where('category_id', '=', $post['category_id'])->first();

                if (empty($preventStore)) {
                    $store = Store::create([
                        'user_id'     => $user->id,
                        'label'       => $post['label'],
                        'descript'    => $post['descript'],
                        'category_id' => $post['category_id'],
                        'is_shorter' => !empty($trackUrl) ? 1 : 0
                    ]);

                    // If user want trackUrl
                    if (!empty($trackUrl)) {
                        Url::create([
                            'user_id'   => $user->id,
                            'store_id'  => $store->id,
                            'token'     => Url::generateToken(),
                            'be_notice' => !empty($beNotice) ? 1 : 0
                        ]);

                        $this->fMessage->set('Store added with a shorterLink.'); // TODO Change text
                    } else {
                        $this->fMessage->set('Store added.');
                    }
                } else {
                    $this->fMessage->set('You already have a snippet with this name in this category.', 'error');
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

            $store    = Store::find($this->f3->get('POST.storeId'));
            $is_valid = User::checkForm($this->f3->get('POST'), [
                'label'    => 'required',
                'descript' => 'required'
            ]);

            if ($is_valid === true) {

                // Save Store
                $store->label       = $this->f3->get('POST.label');
                $store->descript    = $this->f3->get('POST.descript');
                $store->save();

                $url                = Url::where('store_id', '=', $store->id)->first();
                $pushbulletValue    = $this->f3->get('POST.pushbullet');

                // Save URL if user want to be notice
                if ($url->be_notice == 1 && !isset($pushbulletValue)) {
                    $url->be_notice = 0;
                    $url->save();
                } else if (isset($pushbulletValue)) {
                    $url->be_notice = 1;
                    $url->save();
                }

                $this->fMessage->set('You have update your snippet with success.');
                $this->f3->reroute('/category/'.$store->category_id);

            } else {
                $this->fMessage->set('You must insert the name and the content.', 'error');
                $this->f3->reroute('/stores/edit/'.$store->id);
            }

        } else {
            $store = Store::find($id);

            if ($store->is_shorter == 1) {
                $url        = Url::where('store_id', '=', $store->id)->first();
                $beNotice   = $url->be_notice;
            } else {
                $beNotice = null;
            }

            $this->render(true, [
                'values'    => $store,
                'id'        => $id,
                'be_notice' => $beNotice
            ]);
        }

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
        $store = Store::find($id);
        if ($store->delete()) {
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
