<?php

namespace MyDropper\Controllers;

/**
 * Class TrackingController
 * @package MyDropper\Controllers
 */
class TrackingController extends BaseController
{
    /**
     * GET /tracking
     */
    public function index()
    {
        $this->need->logged('/users/login')->execute();

        $this->render(true);
    }
}
