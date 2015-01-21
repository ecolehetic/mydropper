<?php

/**
 * Class IndexController
 */
class IndexController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    function index($f3)
    {
        $this->render('main.twig', [
            'user' => 'Equipe 14'
        ]);
    }

}