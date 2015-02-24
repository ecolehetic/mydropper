<?php

namespace Mydropper\Helpers;

/**
 * Class BaseHelper
 * @package Mydropper\Helpers
 */
class BaseHelper
{

    protected $f3;
    protected $web;

    public function __construct()
    {
        $this->web  = \Web::instance();
        $this->f3   = \Base::instance();
    }

}