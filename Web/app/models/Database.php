<?php

namespace APP\MODELS;

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Class Database
 * @package APP\MODELS
 */
class Database
{

    /**
     * @var array Stock Settings Variables
     */
    private $settings = array();
    /**
     * @var Capsule Stock Capsule use for Eloquent
     */
    private $capsule;

    /**
     * Init Database
     */
    public function __construct()
    {
        $this->initSettings();
        $this->capsule = new Capsule;
        $this->capsule->addConnection($this->settings);
        $this->capsule->bootEloquent();

        return $this->capsule;
    }

    /**
     * Init Settings, go to F3 config and add it in Settings
     */
    private function initSettings()
    {
        $f3 = \Base::instance();
        $this->settings['driver']       = $f3->get('DB_DRIVER');
        $this->settings['host']         = $f3->get('DB_HOST');
        $this->settings['port']         = $f3->get('DB_PORT');
        $this->settings['database']     = $f3->get('DB_NAME');
        $this->settings['username']     = $f3->get('DB_USER');
        $this->settings['password']     = $f3->get('DB_PASS');
        $this->settings['charset']      = $f3->get('DB_CHARSET');
        $this->settings['collation']    = $f3->get('DB_COLLATION');
        $this->settings['prefix']       = $f3->get('DB_PREFIX');
        $this->settings['unix_socket']  = $f3->get('DB_UNIX_SOCKET');
    }

}