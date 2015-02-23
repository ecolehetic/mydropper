<?php

namespace MyDropper\Helpers;

/**
 * Class FlashMessage
 * @package Mydropper\HELPERS
 */


class FlashMessage extends BaseHelper
{

    /**
     * Set a Flash Message
     *
     * @param string $message
     */
    public function set($message, $status = 'info')
    {
        $this->f3->set('SESSION.fMessage.message', htmlentities($message));
        $this->f3->set('SESSION.fMessage.status', $status);
    }

    /*
     * Return the Flash Message
     */
    public function get()
    {
        if ($this->f3->get('SESSION.fMessage') !== null) {
            return $this->f3->get('SESSION.fMessage');
        } else {
            return false;
        }
    }

    /**
     * Destroy the Flash Message
     */
    public function destroy()
    {
        if ($this->f3->get('SESSION.fMessage') !== null) {
            $this->f3->clear('SESSION.fMessage');
        }
    }

}