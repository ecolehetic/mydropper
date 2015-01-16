<?php

$f3 = require('framework/f3/base.php');

$f3->config('app/config/config.ini');
$f3->config('app/config/routes.ini');

$f3->set('AUTOLOAD', 'app/ | app/controllers/ | app/models/');

$f3->run();