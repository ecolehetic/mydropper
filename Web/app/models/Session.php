<?php

namespace APP\MODELS;

/**
 * Class Session
 * @package APP\MODELS
 */
class Session
{

    private static $f3;

    public function __construct()
    {
        new \Session();
        self::$f3 = \Base::instance();
    }

    /**
     * Create in Session the user
     * @param $data
     */
    public static function create($data)
    {
        self::$f3->set('SESSION.logged', true);
        self::$f3->set('SESSION.user', $data);
    }

    /**
     * Destroy the session
     */
    public static function destroy()
    {
        self::$f3->clear('SESSION');
    }

}