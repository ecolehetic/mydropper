<?php

namespace MyDropper\controllers;

use MyDropper\helpers\Upload;
use MyDropper\models\User;

/**
 * Class ProfileController
 * @package MyDropper\Controllers
 */
class ProfileController extends BaseController
{
    const DEFAULT_AVATAR = "assets/images/default-avatar.jpg";

    /**
     * GET /profile
     */
    public function index()
    {
        $user   = $this->need->logged('/users/login')->user()->execute();

        $avatar = file_exists($user->avatar_url) ? $user->avatar_url : self::DEFAULT_AVATAR;

        $this->render(true, [
            'values' => $user,
            'avatar' => $avatar
        ]);
    }

    /**
     * POST /profile
     */
    public function update()
    {
        $this->need->logged('/users/login')->user()->execute();

        $validForm = User::checkForm($this->f3->get('POST'), array(
            'username'        => 'required|max_len,50',
            'firstname'       => 'required|max_len,45',
            'lastname'        => 'required|max_len,45',
            'mail'            => 'required|valid_email',
            'mail_pushbullet' => 'valid_email',
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
            $user->mail_pushbullet  = $this->f3->get('POST.mail_pushbullet');

            if (!empty($password_1) && !empty($password_2)) {
                if ($this->f3->get('POST.password_1') === $this->f3->get('POST.password_2')) {
                    $user->password    = $this->crypt($this->f3->get('POST.password_1'));
                }
            } else {
                $this->fMessage->set('The passwords must be the same.', 'error');
            }

            if ($this->f3->get('FILES.avatar')) {
                $upload           = new Upload();
                $path             = $upload->save($this->f3->get('FILES.avatar'));
                if (!empty($path)) {
                    if ($user->avatar_url){
                        if(file_exists($user->avatar_url) && ($user->avatar_url != self::DEFAULT_AVATAR)){
                            unlink($user->avatar_url);
                        }
                    }
                    $user->avatar_url = $path;
                }
            }

            $user->save();

            $this->fMessage->set('Your profile has been update.');
        }

        $this->f3->set('SESSION.user', User::find($userInformations->id));
        $user   = User::find($userInformations->id);
        $avatar = file_exists($user->avatar_url) ? $user->avatar_url : self::DEFAULT_AVATAR;

        $this->render('profile/index.twig', [
            'values' => $user,
            'avatar' => $avatar
        ]);
    }
}
