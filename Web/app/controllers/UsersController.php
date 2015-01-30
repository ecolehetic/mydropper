<?php

namespace APP\CONTROLLERS;

use App\Models\User as User;


/**
 * Class IndexController
 */
class UsersController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    function create($f3)
    {

        $this->render('main.twig', [
            
        ]);
    }

    function edit($f3)
    {
        
        $this->render('main.twig', [
            
        ]);
    }

    function delete($f3)
    {
        
        $this->render('main.twig', [
            
        ]);
    }

}