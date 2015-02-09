<?php

namespace APP\MODELS;

/**
 * Class Session
 * @package APP\MODELS
 */
class Session
{

    private $f3;

    public function __construct()
    {
        new \Session();
        $this->f3 = \Base::instance();
    }

    /**
     * Create in Session the user
     * @param $data
     */
    public function create($data)
    {
        $this->f3->set('SESSION.logged', true);
        $this->f3->set('SESSION.user', $data);
    }

    /**
     * Destroy the session
     */
    public function destroy()
    {
        $this->f3->clear('SESSION');
    }

}