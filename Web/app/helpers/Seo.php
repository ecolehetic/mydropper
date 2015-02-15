<?php

namespace APP\HELPERS;

/**
 * Class Seo
 * @package APP\HELPERS
 */
class Seo
{

    private static $_instance;

    /**
     * Get the SEO files and save it variable
     */
    private function __construct()
    {
        $this->settings = require(dirname(__DIR__) . '/config/seo.php');
    }

    /**
     * Singleton
     *
     * @return Seo
     */
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Seo();
        }
        return self::$_instance;
    }

    /**
     * Get the (title|description)
     *
     * @param string $controller
     * @param string $method
     * @param string $value
     *
     * @return array
     */
    public function get($controller, $method, $value)
    {
        if (!isset($this->settings[$controller][$method])) {
            return $this->settings['index']['index'][$value];
        }
        return $this->settings[$controller][$method][$value];
    }

}