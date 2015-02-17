<?php

namespace APP\CONTROLLERS;

use APP\HELPERS\Mail;
use APP\HELPERS\Upload;
use APP\HELPERS\Url;
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
        $this->need->unLogged('/dashboard')->execute();

        $this->render(true);
    }


    /**
     * POST users/create
     * @throws \APP\HELPERS\Exception
     */
    function create()
    {
        $validForm = User::checkFormSubscribe($this->f3->get('POST'));

        if ($validForm === true) {
            $username   = User::where('username', $this->f3->get('POST.username'))->first();
            $mail       = User::where('mail', $this->f3->get('POST.mail'))->first();

            if ($username === null && $mail === null) {

                if ($this->f3->get('FILES.avatar')) {
                    $upload = new Upload();
                    $path   = $upload->save($this->f3->get('FILES.avatar'));
                } else {
                    $path = null;
                }


                // ADD A SPECIFIC CASE FOR USER CREATE FROM ADMIN


                $user = User::create(array(
                    'username'      => $this->f3->get('POST.username'),
                    'firstname'     => $this->f3->get('POST.firstname'),
                    'name'          => $this->f3->get('POST.lastname'),
                    'mail'          => $this->f3->get('POST.mail'),
                    'date_of_birth' => $this->f3->get('POST.birthday'),
                    'password'      => $this->crypt($this->f3->get('POST.password_1')),
                    'avatar_url'    => $path
                ));


                $this->f3->set('POST.id', $user->id);
                $this->f3->set('SESSION.user', $this->f3->get('POST'));

                $this->f3->reroute('/users/login', true); // TODO change it to the Dashboard
            } else {
                $validForm = [];
                if ($username !== null) {
                    $validForm[] = "The username is already token.";
                }
                if ($mail !== null) {
                    $validForm[] = "The mail is already token.";
                }
            }
        }

        $this->render('users/subscribe.twig', [
            'messages' => $validForm,
            'values'   => $this->f3->get('POST')
        ]);

    }

    /*
     * GET users/login
     */
    public function login()
    {
        $this->need->unLogged('/dashboard')->execute();

        $this->render(true, [
            'values'   => ($this->f3->get('SESSION.user.username')) ? $this->f3->get('SESSION.user.username') : '',
            'messages' => ($this->fMessage->get()) ? ($this->fMessage->get()) : ''
        ]);
    }

    /*
     * POST users/connect
     */
    public function connect()
    {

        $validForm = User::checkForm($this->f3->get('POST'), array(
            'username' => 'required',
            'password' => 'required'
        ));

        if ($validForm === true) {
            $user       = User::where('username', $this->f3->get('POST.username'))->where('password', $this->crypt($this->f3->get('POST.password')))->first();
            $validForm  = [];

            if ($user !== null) {
                $this->f3->set('SESSION.user', $user);
                $this->fMessage->set('You are successfully logged');
                $this->f3->reroute('/dashboard', true);
            } else {
                $validForm[] = "User don't exist";
            }
        }

        $this->render('users/login.twig', [
            'messages' => $validForm,
            'values'   => $this->f3->get('POST')
        ]);
    }

    /*
     * GET users/lostpassword
     */
    public function lostPassword()
    {
        $this->need->unLogged('/dashboard')->execute();

        $this->render(true);
    }

    /*
     * POST users/lostpassword
     */
    public function seedMailLostPassword()
    {
        $validForm = User::checkForm($this->f3->get('POST'), array(
            'mail' => 'required|valid_email'
        ));

        if ($validForm === true) {

            $userInformations   = User::where('mail', $this->f3->get('POST.mail'))->first();
            $token              = uniqid();
            $validForm          = [];

            if ($userInformations !== null) {
                // Generate Token and save it
                $user                   = User::find($userInformations->id);
                $user->token            = $token;
                $user->is_lost_password = 1;
                $user->save();

                // Define URL
                $urlHelper = new Url();
                $url = $urlHelper->generate('/users/lostpassword/', array(
                    $userInformations->username,
                    $token
                ));

                // Seed Mail
                $mail = new Mail();
                $mail->seed('lostpassword_first_step', $this->f3->get('POST.mail'), array(
                    'subject' => 'Mot de passe oublié',
                    'link' => $url
                ));

                // Display Messages
                if ($mail) {
                    $validForm[] = "Message seeded.";
                } else {
                    $validForm[] = "Error during seeding mail. Try again.";
                }
            } else {
                $validForm[] = "The email does not exist in our database.";
            }

        }

        $this->render('users/lostpassword.twig', [
            'messages' => $validForm
        ]);
    }

    /*
     * GET users/lostpassword/@username/@token
     */
    public function confirmLostPassword()
    {
        $userInformations   = User::where('username', $this->f3->get('GET.username'))->where('token', $this->f3->get('GET.username'))->first();
        $messages           = [];

        if ($userInformations !== null) {
            $newPassword = uniqid();

            // Save new Password
            $user                   = User::find($userInformations->id);
            $user->token            = null;
            $user->is_lost_password = 0;
            $user->password         = $this->crypt($newPassword);
            $user->save();

            // Seed a mail with new Password
            // Seed Mail
            $mail = new Mail();
            $mail->seed('lostpassword_final_step', $userInformations->mail, array(
                'subject' => 'Mot de passe oublié',
                'password' => $newPassword
            ));

            $messages[] = "Your new password has been sent to your mail.";

            // After 3s, redirect to the login page
            sleep(3);
            $this->f3->reroute('/users/login', true);

        } else {
            $messages[] = "The token does not match with the username";
        }

        $this->render('users/lostpassword.twig', [
            'messages' => $messages
        ]);
    }

    /**
     * Logout the user
     */
    public function logout()
    {
        $this->f3->clear('SESSION');
        $this->f3->reroute('/');
    }

}