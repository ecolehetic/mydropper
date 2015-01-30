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
    private $view;
    public $layout = 'layout';

    /**
     * Return in all Child Constructor $twig, $f3, $web
     */
    public function __construct()
    {
        $this->f3   = \Base::instance();
        $this->web  = \Web::instance();
        $this->twig = $this->f3->get('TWIG');
        $this->getControllerName();
    }

    /**
     * @param string $file Name of the Twig File
     * @param array $values Values inject in the View
     */
    protected function render($file, $values = [])
    {
        $values['layout'] = $this->layout;
        echo $this->twig->render($this->view . '/' . $file, $values);
    }

    /**
     * Get The Folder name for the Views
     */
    private function getControllerName()
    {
        foreach ($this->f3['ROUTES'] as $key => $value) {

            if ($this->f3['URI'] == $key) {
                $explode        = explode('\\', $value[3]['GET'][0]);
                $end            = end($explode);
                $secondExplode  = explode('Controller', $end);
                $this->view     = strtolower($secondExplode[0]);
            }

        }

    }

    public function afterroute($f3){
        var_dump(__CLASS__);

    }

}