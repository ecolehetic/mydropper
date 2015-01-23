<?php

/*
 * Autoload By Composer
 */
require('vendor/autoload.php');

use \APP\MODELS\Database;

/*
 * Fat Free Framework
 */
$f3 = Base::instance();

$f3->config('app/config/config.ini');
$f3->config('app/config/routes.ini');

/*
 * Twig
 */
Twig_Autoloader::register();

$twig = new Twig_Environment(new Twig_Loader_Filesystem('app/views/'), [
    'debug'         => false,
    'cache'         => 'assets/cache/',
    'auto_reload'   => true
]);

/*
 * Eloquent
 */
$capsule = new Database();

/*
 * Run
 */
$f3->run();