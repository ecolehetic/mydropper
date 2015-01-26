<?php

namespace APP\CONTROLLERS;

use App\Models\User as User;
use App\Models\Role as Role;

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

        // The follow method doesnt load Role Model
        $user = User::find(1)->roles()->get();

        $this->render('main.twig', [
            'user' => $user
        ]);
    }

}