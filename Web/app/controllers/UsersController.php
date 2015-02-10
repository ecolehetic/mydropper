<?php

namespace APP\CONTROLLERS;

use App\Models\User as User;

/**
 * Class IndexController
 */
class UsersController extends BaseController
{

    /*
     * GET users/subscribe
     */
    public function subscribe()
    {
        $this->render(true);
    }

    /*
     * POST users/create
     */
    function create()
    {
        $validForm = User::checkFormSubscribe($this->f3->get('POST'));

        if($validForm === true){
            $username   = User::where('username', $this->f3->get('POST.username'))->first();
            $mail       = User::where('mail', $this->f3->get('POST.mail'))->first();

            if($username === null && $mail === null){

                $user = User::create(array(
                    'username'      => $this->f3->get('POST.username'),
                    'firstname'     => $this->f3->get('POST.firstname'),
                    'name'          => $this->f3->get('POST.lastname'),
                    'mail'          => $this->f3->get('POST.mail'),
                    'date_of_birth' => $this->f3->get('POST.birthday'),
                    'password'      => $this->crypt($this->f3->get('POST.password_1'))
                ));

                $this->f3->set('POST.id', $user->id);
                $this->f3->set('SESSION.user', $this->f3->get('POST'));

                $this->f3->reroute('/users/login', true);
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
            'values' => $this->f3->get('POST')
        ]);

    }

    /*
     * GET users/login
     */
    public function login()
    {
        $this->render(true, [
            'values' => ($this->f3->get('SESSION.user.username')) ? $this->f3->get('SESSION.user.username') : '',
            'messages' => ($this->fMessage->get()) ? ($this->fMessage->get()) : ''
        ]);
    }

    /*
     * POST users/connect
     */
    public function connect()
    {
        $validForm = User::checkFormConnect($this->f3->get('POST'));

        if($validForm === true){
            // TODO Get user information in database
        }

        $this->render('users/subscribe.twig', [
            'messages' => $validForm,
            'values' => $this->f3->get('POST')
        ]);

    }

}