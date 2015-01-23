<?php

namespace APP\CONTROLLERS;

/**
 * Class BaseController
 * @package APP\CONTROLLERS
 */
class BaseController
{

    private $twig;
    protected $f3;
    protected $web;
    public $layout = 'layout';

    /**
     * Return in all Child Constructor $twig, $f3, $web
     */
    public function __construct()
    {
        $this->f3   = \Base::instance();
        $this->web  = \Web::instance();
        $this->twig = $this->f3->get('TWIG');
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