<?php

namespace MyDropper\controllers;

use MyDropper\models\TrackerStore;
use MyDropper\models\TrackerUrl;
use MyDropper\models\Url;
use MyDropper\models\User;
use MyDropper\models\Store;
use MyDropper\models\Category;

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

        $users                      = User::with('roles')->get();

        $usersCount                 = User::count();

        $storesCount                = Store::count();
        $storesCountAll             = Store::withTrashed()->count();

        $categoriesCount            = Category::count();
        $categoriesCountAll         = Category::withTrashed()->count();

        $urlsCount                  = Url::count();
        $urlsCountAll               = Url::withTrashed()->count();

        $trackersStoresCount        = TrackerStore::count();
        $trackersStoresCountAll     = TrackerStore::withTrashed()->count();

        $trackersUrlsCount          = TrackerUrl::count();
        $trackersUrlsCountAll       = TrackerUrl::withTrashed()->count();


        $this->render(true, [
            'usersCount'             => $usersCount,
            'storesCount'            => $storesCount,
            'storesCountAll'         => $storesCountAll,
            'categoriesCount'        => $categoriesCount,
            'categoriesCountAll'     => $categoriesCountAll,
            'urlsCount'              => $urlsCount,
            'urlsCountAll'           => $urlsCountAll,
            'trackersStoresCount'    => $trackersStoresCount,
            'trackersStoresCountAll' => $trackersStoresCountAll,
            'trackersUrlsCount'      => $trackersUrlsCount,
            'trackersUrlsCountAll'   => $trackersUrlsCountAll,
            'users'                  => $users
        ]);
    }

    /**
     * GET /debug
     */
    public function debug()
    {
        $this->need->logged('/users/login')->minimumLevel(9)->execute();


        $user =  User::paginate(4);

        var_dump($user);
        $this->render('debug.twig', [

        ]);
    }
}
