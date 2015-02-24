<?php

namespace MyDropper\Helpers;

use Twig_Autoloader;
use Twig_Environment;
use Twig_Filter_Function;
use Twig_Loader_Filesystem;

/**
 * Class Twig
 * @package MyDropper\Helpers
 */
class Twig extends BaseHelper
{

    private $folder;

    /**
     * @param $viewFolder
     * @param $params
     */
    public function __construct($viewFolder, $params)
    {
        parent::__construct();

        $this->folder = $this->f3->get('ASSETS');

        Twig_Autoloader::register();

        $Twig_env = new Twig_Environment(new Twig_Loader_Filesystem(($viewFolder), $params));
        // Dump Filter
        $Twig_env->addFilter('dump', new Twig_Filter_Function('var_dump'));
        // URL Generator
        $Twig_env->addFunction(new \Twig_SimpleFunction('url', function ($path, $params = [], $is_admin = false) {
            $urlHelper = new Url();
            return $urlHelper->generate($path, $params, $is_admin);
        }));
        // Asset Function
        $Twig_env->addFunction(new \Twig_SimpleFunction('asset', function ($type, $asset, $extern) {
            $link = ($extern === true) ? $asset : '/' . $this->folder . $type . '/' . $asset;
            if ($type === 'js') {
                echo sprintf("<script src='%s' type='text/javascript'></script>", $link);
            } else {
                if ($type === 'css') {
                    echo sprintf("<link href='%s' type='text/css' rel='stylesheet'/>", $link);
                } else {
                    return null;
                }
            }
        }));

        $this->f3->set('TWIG', $Twig_env);
    }
}
