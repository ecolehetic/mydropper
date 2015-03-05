<?php

namespace MyDropper\controllers;

use MyDropper\models\TrackerStore;
use MyDropper\models\User;

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
        $trackersCount = TrackerStore::where('user_id', '=', $user->id)->count();

        $this->render(true, [
            'trackers' => $trackersCount
        ]);
    }

}
