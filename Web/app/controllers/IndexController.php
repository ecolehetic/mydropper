<?php

namespace MyDropper\Controllers;

use MyDropper\Models\TrackerStore;
use MyDropper\Models\TrackerUrl;
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
        $storesCountAll = Store::withTrashed()->count();

        $categoriesCount = Category::count();
        $categoriesCountAll = Category::withTrashed()->count();

        $urlsCount = Url::count();
        $urlsCountAll = Url::withTrashed()->count();

        $trackersStoresCount = TrackerStore::count();
        $trackersStoresCountAll = TrackerStore::withTrashed()->count();

        $trackersUrlsCount = TrackerUrl::count();
        $trackersUrlsCountAll = TrackerUrl::withTrashed()->count();


        $this->render(true, [
            'usersCount' => $usersCount,
            'storesCount' => $storesCount,
            'storesCountAll' => $storesCountAll,
            'categoriesCount' => $categoriesCount,
            'categoriesCountAll' => $categoriesCountAll,
            'urlsCount' => $urlsCount,
            'urlsCountAll' => $urlsCountAll,
            'trackersStoresCount' => $trackersStoresCount,
            'trackersStoresCountAll' => $trackersStoresCountAll,
            'trackersUrlsCount' => $trackersUrlsCount,
            'trackersUrlsCountAll' => $trackersUrlsCountAll,
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
