<?php

namespace APP\MODELS;

use Twig_Autoloader;
use Twig_Environment;
use Twig_Loader_Filesystem;

class Twig
{
    public function __construct($viewFolder, $params)
    {
        $f3 = \Base::instance();

        Twig_Autoloader::register();

        $f3->set('TWIG', new Twig_Environment(new Twig_Loader_Filesystem(($viewFolder), $params)));
    }
}