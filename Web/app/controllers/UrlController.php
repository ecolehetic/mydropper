<?php

namespace MyDropper\controllers;

use MyDropper\models\Store;
use MyDropper\models\TrackerUrl;
use MyDropper\models\Url;
use Pushbullet;

/**
 * Class UrlController
 * @package MyDropper\Controllers
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
                    if ((int)$shortLink->be_notice === 1) {
                        if (!empty($shortLink->users->mail_pushbullet)) {
                            if ($this->f3->get('PUSHBULLET_ENABLE') == true) {
                                $this->seedNotification($shortLink->users->mail_pushbullet, $store->descript);
                            }
                        }
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
            $pushbullet->pushNote($mail, 'MyDropper', sprintf(self::MESSAGE, strtolower($url)));

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
