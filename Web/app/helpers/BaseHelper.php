<?php

namespace APP\HELPERS;

/**
 * Class BaseHelper
 * @package APP\HELPERS
 */
class BaseHelper {

    protected $f3;

    public function __construct()
    {
        $this->f3 = \Base::instance();
    }

}