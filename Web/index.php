<?php

/*
 * TWIG
 */

require('vendor/twig/twig/lib/Twig/Autoloader.php');

Twig_Autoloader::register();

$twig = new Twig_Environment(new Twig_Loader_Filesystem('app/views/'), [
    'debug'         => false,
    'cache'         => 'assets/cache/',
    'auto_reload'   => true
]);

/*
 * Fat Free Framework
 */

$f3 = require('vendor/bcosca/fatfree/lib/base.php');

$f3->config('app/config/config.ini');
$f3->config('app/config/routes.ini');

$f3->run();