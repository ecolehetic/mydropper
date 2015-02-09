<?php

namespace APP\CONTROLLERS;

use App\Models\User as User;
use App\Models\Session as Session;

/**
 * Class IndexController
 */
class UsersController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function subscribe()
    {

        $this->render(true);
    }

    function create($f3)
    {
        $validForm = User::checkFormSubscribe($f3->get('POST'));

        if($validForm === true){
            $username   = User::where('username', $f3->get('POST.username'))->first();
            $mail       = User::where('mail', $f3->get('POST.mail'))->first();

            if($username === null && $mail === null){

                $user = User::create(array(
                    'username'      => $f3->get('POST.username'),
                    'firstname'     => $f3->get('POST.firstname'),
                    'name'          => $f3->get('POST.lastname'),
                    'mail'          => $f3->get('POST.mail'),
                    'date_of_birth' => $f3->get('POST.birthday'),
                    'password'      => $this->crypt($f3->get('POST.password_1'))
                ));

                $f3->set('POST.id', $user->id);

                $session = new Session();
                $session->create($f3->get('POST'));

                // TODO Redirect to connect page

            }
            else{
                $validForm = [];
                if($username !== null){
                    array_push($validForm, 'The username is already token');
                }
                if($mail !== null){
                    array_push($validForm, 'The mail is already token');
                }
            }
        }

        $this->render('users/subscribe.twig', [
            'messages' => $validForm,
            'values' => $f3->get('POST')
        ]);

    }

}