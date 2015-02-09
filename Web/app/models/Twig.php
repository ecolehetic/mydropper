<?php

namespace APP\MODELS;

use Twig_Autoloader;
use Twig_Environment;
use Twig_Loader_Filesystem;
use Twig_Filter_Function;

class Twig
{
    private $folder;

    public function __construct($viewFolder, $params)
    {
        $f3 = \Base::instance();
        $this->folder = $f3->get('ASSETS');

        Twig_Autoloader::register();

        $Twig_env = new Twig_Environment(new Twig_Loader_Filesystem(($viewFolder), $params));
        // Dump Filter
        $Twig_env->addFilter('dump', new Twig_Filter_Function('var_dump'));
        // Asset Function
        $Twig_env->addFunction(new \Twig_SimpleFunction('asset', function ($type, $asset) {
            $link = $this->folder . $type . '/' . $asset;
            if ($type === 'js') {
                echo sprintf("<script src='/%s' type='text/javascript'></script>", $link);
            } else if ($type === 'css') {
                echo sprintf("<link href='/%s' type='text/css' rel='stylesheet'/>", $link);
            } else {
                return null;
            }
        }));

        $f3->set('TWIG', $Twig_env);
    }
}