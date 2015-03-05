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

        $trackers = TrackerStore::where('user_id', '=', $user->id)->with('stores')->orderBy('created_at', 'desc')->get();

        $this->render(true, [
            'trackers' => $trackers
        ]);
    }

    /**
     * Get async history
     * POST /historyasync
     *
     * @param string $tokenApi
     * @param int $userId
     * @param int $pagination
     * @param int $pages
     *
     */
    public function getHistory(){
        $tokenApi = $this->f3->get('POST.token_api');
        $userId = (int)($this->f3->get('POST.user_id'));
        $pagination = (int)($this->f3->get('POST.pagination'));
        $pages = (int)($this->f3->get('POST.pages'));

        $json = [];
        if($tokenApi){
            $user = User::where('token_api', '=', $tokenApi)->where('id', '=', $userId)->with('roles')->first();
            if($user){
                $json['trackers'] = TrackerStore::where('user_id', '=', $userId)->take($pagination)->offset($pages*$pagination)->with('stores')->orderBy('created_at', 'desc')->get();
            }else{
                $json['error'] = 'error occurred (no user)';
            }
        }else{
            $json['error'] = 'error occurred (no token)';
        }
        $this->render(false, $json);
    }
}
