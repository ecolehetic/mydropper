<?php

namespace MyDropper\controllers;

use MyDropper\helpers\FlashMessage;
use MyDropper\helpers\Need;
use MyDropper\helpers\Seo;
use MyDropper\models\Store;
use MyDropper\models\User;

/**
 * Class BaseController
 * @package MyDropper\Controllers
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

    /**
     * Return in all Child Constructor $twig, $f3, $web
     */
    public function __construct()
    {
        $this->f3       = \Base::instance();
        $this->web      = \Web::instance();
        $this->fMessage = new FlashMessage();
        $this->need     = new Need();
        $this->twig     = $this->f3->get('TWIG');
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
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            echo json_encode($values);
            return;
        } else {
            $tpl = $file;
        }

        $values = $this->defaultValueRender($values);

        echo $this->twig->render($tpl, $values);

        $this->fMessage->destroy();
    }

    /**
     * Return the Path without / for active menu
     */
    private function getActiveMenu()
    {
        $path    = $this->f3->get('PATH');
        $explode = explode('/', $path);
        return [
            'path' => $explode[1],
            'id'   => (isset($explode[2])) ? $explode[2] : null
        ];
    }

    /**
     *  Add default values in all twig render
     *
     * @param array $values
     *
     * @return array
     */
    private function defaultValueRender($values)
    {
        // SEO
        $values['seo']['title']         = Seo::getInstance()->get($this->controller, $this->action, 'title');
        $values['seo']['description']   = Seo::getInstance()->get($this->controller, $this->action, 'description');

        // Active menu
        $values['aside']['active'] = $this->getActiveMenu();

        // FlashMessage
        if ($this->fMessage->get() !== false) {
            $values['fMessage'] = $this->fMessage->get();
        }

        // Variables in (aside.twig) when user is logged
        if ($this->need->testLogged() === false) {
            $user = $this->f3->get('SESSION.user');

            // Users informations
            $values['aside']['user_id']     = $user->id;
            $values['aside']['name']        = $user->name;
            $values['aside']['firstname']   = $user->firstname;
            $values['aside']['token_api']   = $user->token_api;

            $values['aside']['role_id']     = $user->role_id;
            $values['aside']['avatar_url']  = file_exists($user->avatar_url) ? $user->avatar_url : 'assets/images/default-avatar.jpg';

            // Categories with Stores
            $categories                = User::find($user->id)->categories()->get();
            $values['aside']['stores'] = [];

            for ($i = 0; $i < count($categories); $i++) {
                array_push($values['aside']['stores'], [
                    'category_id'    => $categories[$i]->id,
                    'category_label' => $categories[$i]->label,
                    'stores'         => []
                ]);

                $stores = Store::where('category_id', $categories[$i]->id)->get();

                for ($j = 0; $j < count($stores); $j++) {
                    $values['aside']['stores'][$i]['stores'][] = [
                        'store_id'          => $stores[$j]->id,
                        'store_label'       => $stores[$j]->label,
                        'store_description' => $stores[$j]->descript,
                        'store_active'      => $stores[$j]->is_active
                    ];
                }
            }
        }

        return $values;
    }

    /**
     * Get the targeted template by url
     * Set as protected $action, $controller & $method
     */
    private function getTpl()
    {
        $this->method = $this->f3['SERVER']['REQUEST_METHOD'];

        $params = $this->f3['PARAMS'];
        if(!empty($this->f3['PARAMS'][0])) {
            $base = $this->f3['PARAMS'][0];
        } else {
            $base = '/onerror';
        }

        if (count($this->f3['PARAMS']) > 1) {
            unset($params[0]);
            $index = null;
            foreach ($params as $k => $v) {
                $base = str_replace('/' . $v, '', $base);
                $index = '/@' . $k.$index;
            }
            $index = $base.$index;
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

        $mode  = $this->f3->get('MODE');

        return $crypt->hash($string, $this->f3->get('SALT_'.$mode), $level);
    }
}
