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
        // Mocking a new User
        //$user = new User;
        //$user->name = 'John';
        //$user->save();

        $user = User::find(1);
        // var_dump($user);
        // $user = User::find(1);
        $debug = User::find(1)->stores()->get();

        $this->render('main.twig', [
            'user' => $user->firstname,
            'debug' => $debug
        ]);
    }

    function debug($f3){
        $this->render('debug.twig', [
            
        ]);
    }

}