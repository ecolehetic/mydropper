<?php

namespace APP\HELPERS;

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Class Database
 * @package APP\MODELS
 */
class Database extends BaseHelper
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
        parent::__construct();
        
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
        $this->settings = [
            'driver'      => $this->f3->get('DB_DRIVER'),
            'host'        => $this->f3->get('DB_HOST'),
            'port'        => $this->f3->get('DB_PORT'),
            'database'    => $this->f3->get('DB_NAME'),
            'username'    => $this->f3->get('DB_USER'),
            'password'    => $this->f3->get('DB_PASS'),
            'charset'     => $this->f3->get('DB_CHARSET'),
            'collation'   => $this->f3->get('DB_COLLATION'),
            'prefix'      => $this->f3->get('DB_PREFIX'),
            'unix_socket' => $this->f3->get('DB_UNIX_SOCKET')
        ];
    }

}