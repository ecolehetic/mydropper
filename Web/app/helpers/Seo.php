<?php

namespace APP\HELPERS;

/**
 * Class Seo
 * @package APP\HELPERS
 */
class Seo
{

    private $seo = [];
    private static $_instance;

    /**
     * Get the SEO files and save it variable
     */
    private function __construct()
    {
        $this->settings = require(dirname(__DIR__).'/config/seo.php');
    }

    /**
     * Singleton
     *
     * @param $file
     *
     * @return Seo
     */
    public static function getInstance($file)
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Seo();
        }
        return self::$_instance;
    }

    /**
     * Get the (title|description)
     *
     * @param $controller
     * @param $method
     *
     * @return array
     */
    public function get($controller, $method)
    {
        if (!isset($this->settings[$controller][$method])) {
            return null;
        }
        return $this->settings[$controller][$method];
    }

}