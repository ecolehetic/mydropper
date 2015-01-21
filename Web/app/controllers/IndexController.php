<?php

class IndexController extends BaseController
{

    function index($f3)
    {

        $this->render('main.twig', [
            'user' => 'Equipe 14'
        ]);

    }

}