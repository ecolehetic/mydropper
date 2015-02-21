<?php

namespace APP\CONTROLLERS;

use APP\MODELS\User;
use APP\MODELS\Store;
use APP\MODELS\Category;

/**
 * Class IndexController
 */
class IndexController extends BaseController
{

    function index()
    {
        $this->render(true);
    }

    function admin_index()
    {
        $usersCount = User::count();
        $storesCount = Store::count();
        $categoriesCount = Category::count();

        $this->render(true, [
            'usersCount' => $usersCount,
            'storesCount' => $storesCount,
            'categoriesCount' => $categoriesCount
        ]);
    }

    function debug()
    {
        $this->render('debug.twig', [

        ]);
    }

}