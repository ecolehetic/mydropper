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

        $Twig_env = new Twig_Environment(new Twig_Loader_Filesystem(($viewFolder), $params));
        $Twig_env->addExtension(new \Twig_Extension_Debug());
        $f3->set('TWIG', $Twig_env);
    }
}