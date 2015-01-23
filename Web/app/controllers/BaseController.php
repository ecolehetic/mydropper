<?php

namespace APP\CONTROLLERS;

/**
 * Class BaseController
 * @package APP\CONTROLLERS
 */
class BaseController
{

    private $twig;
    public $layout = 'layout';
    protected $f3;
    protected $web;

    /**
     * Return in all Child Constructor $twig, $f3, $web
     */
    public function __construct()
    {
        $this->twig = $GLOBALS['twig'];
        $this->f3   = \Base::instance();
        $this->web  = \Web::instance();
    }


    /**
     * @param string $file Name of the Twig File
     * @param array $values Values inject in the View
     */
    protected function render($file, $values = [])
    {
        $values['layout'] = $this->layout;
        echo $this->twig->render($file, $values);
    }

}