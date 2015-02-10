<?php

namespace APP\HELPERS;

use APP\CONTROLLERS\BaseController;

/**
 * Class FlashMessage
 * @package APP\HELPERS
 */
class FlashMessage extends BaseController{

    /**
     * Call this class in Static
     * @param $name
     * @param $args
     *
     * @return mixed
     */
    public static function __callStatic($name, $args)
    {
        $query = new FlashMessage();
        return call_user_func_array([$query, $name], $args);
    }

    /**
     * Set a Flash Message
     * @param string $message
     */
    protected function set($message)
    {
        $this->f3->set('SESSION.fMessage', htmlentities($message));
    }

}