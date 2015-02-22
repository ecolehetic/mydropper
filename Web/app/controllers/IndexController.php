<?php

namespace APP\CONTROLLERS;

use APP\MODELS\Url;
use APP\MODELS\User;
use APP\MODELS\Store;
use APP\MODELS\Category;

/**
 * Class IndexController
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
        $url = Url::where('token', "=", "234d")->with('users')->get();

        var_dump($url->mail);

        $this->render('debug.twig', [

        ]);
    }

}