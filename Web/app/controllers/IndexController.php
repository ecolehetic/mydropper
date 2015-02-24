<?php

namespace MyDropper\Controllers;

use MyDropper\Models\Url;
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
        $urlsCount = Url::count();


        $this->render(true, [
            'usersCount'      => $usersCount,
            'storesCount'     => $storesCount,
            'categoriesCount' => $categoriesCount,
            'urlsCount'       => $urlsCount
        ]);
    }

    public function debug()
    {
        $this->render('debug.twig', [

        ]);
    }
}
