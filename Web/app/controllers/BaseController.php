<?php

class BaseController
{

    protected $twig;
    protected $f3;
    protected $web;

    public function __construct()
    {
        $this->twig = $GLOBALS['twig'];
        $this->f3   = Base::instance();
        $this->web  = Web::instance();
    }

    /*
     * Render HTML
     * @params string $file
     * @params array $values
     * @return echo Render Twig
     */
    protected function render($file, $values)
    {
    	echo $this->twig->render($file, $values);
    }

}