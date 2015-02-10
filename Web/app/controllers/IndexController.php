<?php

namespace APP\CONTROLLERS;

use APP\MODELS\User;

/**
 * Class IndexController
 */
class IndexController extends BaseController
{

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

        $this->render(true, [
            'user' => $user->firstname,
            'debug' => $debug
        ]);
    }

    function debug(){
        $this->render('debug.twig', [

        ]);
    }

}