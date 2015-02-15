<?php

namespace APP\CONTROLLERS;

/**
 * Class IndexController
 */
class IndexController extends BaseController
{

    function index()
    {
        var_dump($this->fMessage->get());
        $this->render(true);
    }

    function debug()
    {
        $this->render('debug.twig', [

        ]);
    }

}