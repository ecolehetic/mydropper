<?php

namespace APP\CONTROLLERS;

use APP\MODELS\Category;

/**
 * Class CategoryController
 * @package APP\CONTROLLERS
 */
class CategoryController extends BaseController
{

    /**
     *  GET|POST /category/create
     */
    public function create()
    {
        $user = $this->need->logged('/users/login')->user()->execute();

        // Form send
        if ($this->f3->get('POST')) {
            $is_valid = Category::checkForm($this->f3->get('POST'), array(
                'category' => 'required|max_len,45'
            ));

            if ($is_valid === true) {
                Category::create(array(
                    'user_id' => $user->id,
                    'label' => $this->f3->get('POST.category')
                ));

                $this->f3->reroute('/profile', true); //TODO Change it
            }
        }

        $this->render(true);
    }
}