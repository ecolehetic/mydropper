<?php

namespace APP\CONTROLLERS;

/**
 * Class IndexController
 */
class IndexController extends BaseController
{

    function index()
    {
        $this->render(true);
    }

    function debug()
    {
        $this->render('debug.twig', [

        ]);
    }

}