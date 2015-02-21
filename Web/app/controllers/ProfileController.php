<?php

namespace APP\CONTROLLERS;

use APP\MODELS\User;

class ProfileController extends BaseController
{
    /**
     * GET /profile
     */
    public function index()
    {
        $user   = $this->need->logged('/users/login')->user()->execute();
        $age    = $this->getAge($user['date_of_birth']);

        $this->render(true, [
            'values' => $user,
            'age' => $age
        ]);
    }

    /**
     * POST /profile
     */
    public function update()
    {
        $this->need->logged('/users/login')->user()->execute();

        $validForm = User::checkForm($this->f3->get('POST'), array(
            'username'   => 'required|max_len,50',
            'firstname'  => 'required|max_len,45',
            'lastname'   => 'required|max_len,45',
            'mail'       => 'required|valid_email',
            'birthday'   => 'required|date'
        ));

        if ($validForm === true) {

            $userInformations       = $this->f3->get('SESSION.user');
            $password_1             = $this->f3->get('POST.password_1');
            $password_2             = $this->f3->get('POST.password_2');

            $user                   = User::find($userInformations->id);
            $user->username         = $this->f3->get('POST.username');
            $user->firstname        = $this->f3->get('POST.firstname');
            $user->name             = $this->f3->get('POST.lastname');
            $user->mail             = $this->f3->get('POST.mail');
            $user->date_of_birth    = $this->f3->get('POST.birthday');

            // TODO better check and add error in view
            if(!empty($password_1) && !empty($password_2)){
                if($this->f3->get('POST.password_1') === $this->f3->get('POST.password_2')){
                    $user->password    = $this->crypt($this->f3->get('POST.password_1'));
                }
            }

            $user->save();

            $this->fMessage->set('Your profile has been update.');
        }

        $this->f3->set('SESSION.user', User::find($userInformations->id));
        $user   = User::find($userInformations->id);
        $age    = $this->getAge($user['date_of_birth']);

        $this->render('profile/index.twig', [
            'values' => $user,
            'age' => $age
        ]);

    }


    /**
     * Return the age of the user
     * TODO Change it
     *
     * @param string $dateOfBirthday
     *
     * @return string
     */
    private function getAge($dateOfBirthday)
    {
        $explode = explode('/', $dateOfBirthday);

        return date("Y") - end($explode);
    }
}