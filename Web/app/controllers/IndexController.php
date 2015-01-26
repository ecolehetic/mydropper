<?php

namespace APP\CONTROLLERS;

use App\Models\User as User;


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
        // Mocking a new User
        //$user = new User;
        //$user->name = 'John';
        //$user->save();

        // $user = User::find(1)->roles()->get();
        $user = User::find(1);
        $debug = User::find(1)->stores()->get();

        $this->render('main.twig', [
            'user' => $user,
            'debug' => $debug
        ]);
    }

}