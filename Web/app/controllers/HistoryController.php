<?php

namespace APP\CONTROLLERS;

use APP\MODELS\Store as Store;
use APP\MODELS\TrackerStore as TrackerStore;

class HistoryController extends BaseController
{

    /*
     * GET /history
     */
    public function index()
    {

        $user = $this->need->logged('/users/login')->user()->execute();

        //$stores = Store::where('user_id', '=', $user->id)->with('trackerstores')->get();
        $stores = Store::where('user_id', '=', $user->id)->with('categories')->get();
        $trackers = TrackerStore::where('user_id', '=', $user->id)->with('stores')->orderBy('created_at')->get();
        //var_dump($trackers[0]->stores->label);
        //die();

        $this->render(true, [
            'trackers' => $trackers
        ]);
    }

}