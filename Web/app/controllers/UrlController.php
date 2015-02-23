<?php

namespace APP\CONTROLLERS;

use APP\MODELS\Store;
use APP\MODELS\TrackerUrl;
use APP\MODELS\Url;
use \Pushbullet as Pushbullet;

/**
 * Class UrlController
 * @package APP\CONTROLLERS
 */
class UrlController extends BaseController
{

    const MESSAGE = 'Someone click on your URL %s You can check statistic on the website.';

    /**
     * GET /url/@token
     */
    public function redirect()
    {
        $token = $this->f3->get('PARAMS.token');

        if (!empty($token)) {

            $shortLink = Url::where('token', '=', $token)->with('users')->first();

            if (!empty($shortLink)) {

                $store = Store::find($shortLink->store_id);

                if ($this->addTracker($shortLink->user_id, $shortLink->id)) {

                    if($shortLink->be_notice === 1){
                        $this->seedNotification($shortLink->users->mail, $store->descript);
                    }

                    $this->f3->reroute($store->descript, true);
                    return;

                }

            }

        }

        $this->f3->reroute('/', true);
    }

    /**
     * Seed a Notification with PushBullet
     *
     * @param string $mail
     * @param string $url
     *
     * @return bool|string
     */
    private function seedNotification($mail, $url)
    {
        try {
            $pushbullet = new Pushbullet($this->f3->get('PUSHBULLET_API_KEY'));
            $pushbullet->pushNote($mail, 'MyDropper', sprintf(self::MESSAGE, $url));

            return true;
        } catch (PushbulletException $e) {
            return false;
        }

    }

    /**
     * Add A tracker and return true if works
     *
     * @param int $userId
     * @param int $urlId
     *
     * @return bool
     */
    private function addTracker($userId, $urlId)
    {
        $tracker = TrackerUrl::create([
            'user_id' => $userId,
            'url_id'  => $urlId,
        ]);

        return ($tracker) ? true : false;

    }

}