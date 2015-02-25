<?php

namespace MyDropper\Controllers;

use MyDropper\Models\Category;
use MyDropper\Models\Store;

/**
 * Class CategoryController
 * @package MyDropper\Controllers
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
                $category = Category::where('label', '=', $this->f3->get('POST.category'))->first();

                if(empty($category)){
                    Category::create(array(
                        'user_id' => $user->id,
                        'label'   => $this->f3->get('POST.category')
                    ));
                    $this->fMessage->set('Category added.');
                } else {
                    $this->fMessage->set('You have already category with this name', 'error');
                }

                $this->f3->reroute('/history', true);

            }
        }

        $this->render(true);
    }

    /**
     * GET /category/view
     */
    public function view()
    {
        $this->need->logged('/users/login')->execute();

        $categoryId = $this->f3->get('PARAMS.id');

        if (!empty($categoryId)) {
            $stores = Store::where('category_id', '=', $categoryId)->get();
            $category = Category::find($categoryId);
        } else {
            $this->fMessage->set('Error, it missing id of the category.', 'error');
            $this->f3->reroute('/history', true);
        }

        $this->render(true, [
            'stores'       => $stores,
            'categoryName' => $category->label,
            'categoryId'   => $category->id
        ]);
    }

    /**
     * GET /category/delete/@id
     *
     * @param int id
     */
    public function delete()
    {
        $this->need->logged('/users/login')->execute();

        $categoryId = $this->f3->get('PARAMS.id');

        if (!empty($categoryId)) {
            $cat = Category::find($categoryId);
            $cat->delete();

            $this->fMessage->set('Category deleted.', 'alert');
            $this->f3->reroute('/history', true);
        } else {
            $this->f3->reroute('/history', true);
        }
    }
}
