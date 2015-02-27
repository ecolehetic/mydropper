<?php

/*
 * Autoload By Composer
 */
require('vendor/autoload.php');

use MyDropper\helpers\Twig;
use MyDropper\helpers\Database;

/*
 * Fat Free Framework
 */
$f3 = Base::instance();

$f3->config('app/config/config.ini');
$f3->config('app/config/routes.ini');

/*
 * Init 404
 */
$f3->set('ONERROR', function ($f3) {
    echo $f3->get('TWIG')->render('404.twig');
});

/*
 * Twig
 */
new Twig($f3->get('UI'), [
    'debug'       => $f3->get('TWIG_DEBUG'),
    'cache'       => $f3->get('CACHE'),
    'auto_reload' => $f3->get('TWIG_AUTORELOAD')
]);

/*
 * Eloquent
 */
$capsule = new Database();

/*
 * Run
 */
$f3->run();
