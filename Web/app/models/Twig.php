<?php

namespace APP\MODELS;

use Twig_Autoloader;
use Twig_Environment;
use Twig_Loader_Filesystem;
use Twig_Filter_Function;

class Twig
{
    public function __construct($viewFolder, $params)
    {
        $f3 = \Base::instance();

        Twig_Autoloader::register();

        $Twig_env = new Twig_Environment(new Twig_Loader_Filesystem(($viewFolder), $params));
        $Twig_env->addFilter('dump', new Twig_Filter_Function('var_dump'));
        $f3->set('TWIG', $Twig_env);
    }
}