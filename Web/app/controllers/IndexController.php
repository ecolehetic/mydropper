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

    /**
     * GET /
     */
    public function index()
    {
        $this->render(true);
    }

    /**
     * GET /how-are-you
     */
    public function who_we_are()
    {
        $this->render(true);
    }

    /**
     * GET /chrome-extension
     */
    public function chromeExtension()
    {
        $this->need->logged('/users/login')->execute();

        $this->render(true);
    }

    /**
     * GET /how-it-works
     */
    public function howItWorks()
    {
        $this->render(true);
    }

    /**
     * GET /admin
     */
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

    /**
     * GET /debug
     */
    public function debug()
    {
        $this->need->logged('/users/login')->minimumLevel(9)->execute();

        $this->render('debug.twig', [

        ]);
    }
}
