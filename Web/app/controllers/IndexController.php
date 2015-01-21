<?php

class IndexController extends BaseController
{

    function index($f3)
    {

        echo $this->twig->render('main.twig', [
            'user' => 'Equipe 14'
        ]);

    }

}