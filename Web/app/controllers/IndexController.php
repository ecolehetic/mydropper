<?php

namespace MyDropper\Controllers;

use MyDropper\Models\User;
use MyDropper\Models\Store;
use MyDropper\Models\Category;

/**
 * Class IndexController
 * @package MyDropper\Controllers
 */
class IndexController extends BaseController
{

    public function index()
    {
        $this->render(true);
    }

    public function who_we_are()
    {
        $this->render(true);
    }

    public function admin_index()
    {
        $this->need->logged('/users/login')->minimumLevel(9)->user()->execute();
        
        $usersCount = User::count();
        $storesCount = Store::count();
        $categoriesCount = Category::count();

        $this->render(true, [
            'usersCount'      => $usersCount,
            'storesCount'     => $storesCount,
            'categoriesCount' => $categoriesCount
        ]);
    }

    public function debug()
    {
        $this->render('debug.twig', [

        ]);
    }
}
