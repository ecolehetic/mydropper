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

}