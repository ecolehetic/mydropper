<?php

namespace MyDropper\controllers;

use MyDropper\models\TrackerStore;

/**
 * Class HistoryController
 * @package MyDropper\Controllers
 */
class HistoryController extends BaseController
{

    /**
     * GET /history
     */
    public function index()
    {
        $user = $this->need->logged('/users/login')->user()->execute();

        $trackers = TrackerStore::where('user_id', '=', $user->id)->with('stores')->orderBy('created_at')->get();

        $this->render(true, [
            'trackers' => $trackers
        ]);
    }
}
