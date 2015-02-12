<?php

namespace APP\HELPERS;

/**
 * Class BaseHelper
 * @package APP\HELPERS
 */
class BaseHelper
{

    protected $f3;
    protected $web;

    public function __construct()
    {
        $this->web = \Web::instance();
        $this->f3 = \Base::instance();
    }

}