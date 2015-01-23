<?php

namespace APP\CONTROLLERS;

/**
 * Class BaseController
 */
class BaseController
{

    private $twig;
    public $layout = 'layout';
    protected $f3;
    protected $web;

    public function __construct()
    {
        $this->twig = $GLOBALS['twig'];
        $this->f3   = \Base::instance();
        $this->web  = \Web::instance();
    }


    /**
     * @param string $file
     * @param array $values
     */
    protected function render($file, $values = [])
    {
        $values['layout'] = $this->layout;
        echo $this->twig->render($file, $values);
    }

}