<?php

namespace APP\CONTROLLERS;

use APP\HELPERS\FlashMessage;
use APP\HELPERS\Need;
use APP\HELPERS\Seo;

/**
 * Class BaseController
 * @package APP\CONTROLLERS
 */
class BaseController
{

    private $twig;
    private $action;
    private $controller;
    private $method;
    protected $f3;
    protected $web;
    protected $fMessage;
    public $layout = 'layout';

    /**
     * Return in all Child Constructor $twig, $f3, $web
     */
    public function __construct()
    {
        $this->f3 = \Base::instance();
        $this->web = \Web::instance();
        $this->fMessage = new FlashMessage();
        $this->need = new Need();
        $this->twig = $this->f3->get('TWIG');
        $this->getTpl();
    }

    /**
     * @param string | Bool $file true: routeTpl | false: Json | else: Name of the Twig File
     * @param array $values Values inject in the View
     */
    protected function render($file, $values = [])
    {
        if ($file === true) {
            $tpl = $this->controller . '/' . $this->action . '.twig';
        } elseif ($file === false) {
            header('Content-Type: application/json');
            echo json_encode($values);
            return;
        } else {
            $tpl = $file;
        }

        $values['layout'] = $this->layout;
        $values['seo']['title'] = Seo::getInstance()->get($this->controller, $this->method, 'title');
        $values['seo']['description'] = Seo::getInstance()->get($this->controller, $this->method, 'description');

        echo $this->twig->render($tpl, $values);
        $this->fMessage->destroy();
    }


    /**
     * Get the targeted template by url
     * Set as protected $action, $controller & $method
     */
    private function getTpl()
    {

        $this->method = $this->f3['SERVER']['REQUEST_METHOD'];

        $params = $this->f3['PARAMS'];
        $base = $this->f3['PARAMS'][0];
        if (count($this->f3['PARAMS']) > 1) {
            unset($params[0]);
            foreach ($params as $k => $v) {
                $base = str_replace('/' . $v, '', $base);
                $index = $base . '/@' . $k;
            }
        } else {
            $index = $base;
        }

        foreach ($this->f3['ROUTES'] as $key => $value) {

            $trunc = explode('/@', $key);
            if ($trunc[0] == $base) {
                $innerRoute = $this->f3['ROUTES'][$index][3][$this->method][0];
                $first = explode('->', $innerRoute);
                $this->action = $first[1];
                $second = explode('\\', $first[0]);
                $third = explode('Controller', $second[2]);
                $this->controller = strtolower($third[0]);
                break;
            }
        }
    }

    /**
     * Crypt string using Fat Free Framework
     *
     * @param string $string
     * @param int $level
     *
     * @return FALSE|string
     */
    protected function crypt($string, $level = 04)
    {
        $crypt = \Bcrypt::instance();

        return $crypt->hash($string, $this->f3->get('SALT'), $level);
    }

    /**
     * Generate URL with $path and $params
     *
     * @param string $path
     * @param array $params
     *
     * @return string
     */
    protected function urlGenerator($path, $params = [])
    {
        $hive = $this->f3->hive();
        $host = $hive['HEADERS']['Host'];
        $url = 'http://'.$host.$path;

        foreach ($params as $param) {
            $url .= $param.'/';
        }

        return $url;

    }

}