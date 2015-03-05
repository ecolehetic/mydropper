<?php

namespace MyDropper\helpers;

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Class Database
 * @package MyDropper\Helpers
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
        $mode = $this->f3->get('MODE');

        $this->settings = [
            'driver'      => $this->f3->get('DB_'.$mode.'_DRIVER'),
            'host'        => $this->f3->get('DB_'.$mode.'_HOST'),
            'port'        => $this->f3->get('DB_'.$mode.'_PORT'),
            'database'    => $this->f3->get('DB_'.$mode.'_NAME'),
            'username'    => $this->f3->get('DB_'.$mode.'_USER'),
            'password'    => $this->f3->get('DB_'.$mode.'_PASS'),
            'charset'     => $this->f3->get('DB_'.$mode.'_CHARSET'),
            'collation'   => $this->f3->get('DB_'.$mode.'_COLLATION'),
            'prefix'      => $this->f3->get('DB_'.$mode.'_PREFIX'),
            'unix_socket' => $this->f3->get('DB_'.$mode.'_UNIX_SOCKET')
        ];
    }
}
