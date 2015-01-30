<?php

namespace APP\CONTROLLERS;

/**
 * Class IndexController
 */
class IndexController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->render('main.twig', [
            'user' => 'Equipe 14'
        ]);
    }

}