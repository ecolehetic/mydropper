<?php

class IndexController extends BaseController
{

    function index($f3)
    {
        $f3->set('content', 'main.html');
    }

}