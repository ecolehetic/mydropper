<?php

/**
 * Class BaseController
 */
class BaseController
{

    private $twig;
    protected $f3;
    protected $web;

    public function __construct()
    {
        $this->twig = $GLOBALS['twig'];
        $this->f3   = Base::instance();
        $this->web  = Web::instance();
    }


    /**
     * @param $file
     * @param array $values
     */
    protected function render($file, $values = [])
    {
    	echo $this->twig->render($file, $values);
    }

}