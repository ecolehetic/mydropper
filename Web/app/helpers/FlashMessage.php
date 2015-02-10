<?php

namespace APP\HELPERS;

/**
 * Class FlashMessage
 * @package APP\HELPERS
 */
class FlashMessage extends BaseHelper{

    /**
     * Set a Flash Message
     * @param string $message
     */
    public function set($message)
    {
        $this->f3->set('SESSION.fMessage', htmlentities($message));
    }

    /*
     * Return the Flash Message
     */
    public function get()
    {
        if($this->f3->get('SESSION.fMessage') !== null){
            return $this->f3->get('SESSION.fMessage');
        }
    }

    /**
     * Destroy the Flash Message
     */
    public function destroy()
    {
        if($this->f3->get('SESSION.fMessage') !== null){
            $this->f3->clear('SESSION.fMessage');
        }
    }

}