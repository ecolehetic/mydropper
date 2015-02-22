<?php

namespace APP\CONTROLLERS;

use APP\HELPERS\Mail;
use APP\HELPERS\Upload;
use APP\HELPERS\Url;
use APP\HELPERS\Removal;
use APP\MODELS\Category;
use APP\MODELS\Role;
use APP\MODELS\Store;
use App\Models\User;

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
        $this->need->unLogged('/history')->execute();

        $this->render(true);
    }


    /**
     * POST users/create
     * @throws \APP\HELPERS\Exception
     */
    public function create()
    {
        $validForm = User::checkFormSubscribe($this->f3->get('POST'));

        if ($validForm === true) {
            $username = User::where('username', $this->f3->get('POST.username'))->first();
            $mail = User::where('mail', $this->f3->get('POST.mail'))->first();

            if ($username === null && $mail === null) {

                if ($this->f3->get('FILES.avatar')) {
                    $upload = new Upload();
                    $path = $upload->save($this->f3->get('FILES.avatar'));
                } else {
                    $path = null;
                }

                $user = User::create(array(
                    'username' => $this->f3->get('POST.username'),
                    'firstname' => $this->f3->get('POST.firstname'),
                    'name' => $this->f3->get('POST.lastname'),
                    'mail' => $this->f3->get('POST.mail'),
                    'date_of_birth' => $this->f3->get('POST.birthday'),
                    'password' => $this->crypt($this->f3->get('POST.password_1')),
                    'avatar_url' => $path
                ));

                $this->f3->set('POST.id', $user->id);
                $this->f3->set('SESSION.user', $user);

                $this->f3->reroute('/history', true);
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
            'values' => $this->f3->get('POST')
        ]);

    }

    /**
     *
     */
    public function delete()
    {
        $user = $this->need->logged('/users/login')->user()->execute();

        $remove = new Removal($user->id, 'User');
        $remove->cascade(['Category', 'Store', 'TrackerStore'], false);
        User::destroy($user->id);

        $this->f3->clear('SESSION');
        $this->fMessage->set('Your account is deleted', 'alert');
        $this->f3->reroute('/users/login');
    }

    /*
     * GET users/login
     */
    public function login()
    {
        $this->need->unLogged('/history')->execute();

        $this->render(true, [
            'values' => ($this->f3->get('SESSION.user.username')) ? $this->f3->get('SESSION.user.username') : ''
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
            $user = User::where('username', $this->f3->get('POST.username'))->where('password', $this->crypt($this->f3->get('POST.password')))->first();
            $validForm = [];

            if ($user !== null) {
                $this->f3->set('SESSION.user', $user);
                $this->fMessage->set('You are successfully logged');
                $this->f3->reroute('/history', true);
            } else {
                $validForm[] = "User don't exist";
            }
        }

        $this->render('users/login.twig', [
            'messages' => $validForm,
            'values' => $this->f3->get('POST')
        ]);
    }

    /*
     * GET users/lostpassword
     */
    public function lostPassword()
    {
        $this->need->unLogged('/history')->execute();

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

            $userInformations = User::where('mail', $this->f3->get('POST.mail'))->first();
            $token = uniqid();
            $validForm = [];

            if ($userInformations !== null) {
                // Generate Token and save it
                $user = User::find($userInformations->id);
                $user->token_password = $token;
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
        $userInformations = User::where('username', $this->f3->get('PARAMS.username'))->where('token_password', $this->f3->get('PARAMS.token'))->first();
        $messages = [];

        if ($userInformations !== null) {
            $newPassword = uniqid();

            // Save new Password
            $user = User::find($userInformations->id);
            $user->token_password = null;
            $user->is_lost_password = 0;
            $user->password = $this->crypt($newPassword);
            $user->save();

            // Seed a mail with new Password
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
        $this->fMessage->set('You are successfully logout', 'alert');
        $this->f3->reroute('/');
    }

    /**
     * List all users
     * GET /admin/users
     */
    public function admin_index()
    {
        $this->need->logged('/users/login')->minimumLevel(9)->user()->execute();

        $users = User::all();
        $usersCount = count($users);

        $this->render(true, [
            'users' => $users,
            'usersCount'=>$usersCount
        ]);
    }

    /**
     *GET|POST /admin/users/edit/@id
     */
    public function admin_edit()
    {
        $this->need->logged('/users/login')->minimumLevel(9)->user()->execute();

        $id = (int)($this->f3->get('PARAMS.id'));
        $validForm = null;

        if ($this->f3->get('POST') && $id > 0) {
            $validForm = User::checkAdminEdit($this->f3->get('POST'), $id);
            if ($validForm === true) {
                User::where('id', '=', $id)->update([
                    'username' => $this->f3->get('POST.username'),
                    'firstname' => $this->f3->get('POST.firstname'),
                    'name' => $this->f3->get('POST.name'),
                    'mail' => $this->f3->get('POST.mail'),
                    'date_of_birth' => $this->f3->get('POST.birthday'),
                    'role_id'=>$this->f3->get('POST.role_id')
                ]);
            }
        }
        $user = User::find($id);
        $storesCount = Store::where('user_id', '=', $id)->count();
        $categoriesCount = Category::where('user_id', '=', $id)->count();
        $roles = Role::all();

        $this->render(true, [
            'messages' => $validForm,
            'values' => $user,
            'roles'=>$roles,
            'stores' => $storesCount,
            'categories' => $categoriesCount
        ]);
    }

    /**
     * Delete a user
     *GET /admin/users/delete/@id
     */
    public function admin_delete()
    {
        $this->need->logged('/users/login')->minimumLevel(9)->user()->execute();
        $userId = (int)($this->f3->get('PARAMS.id'));

        if ($userId) {
            $userInformations = User::find($userId);
            $remove = new Removal($userId, 'User');
            $remove->cascade(['Category', 'Store', 'TrackerStore'], false);
            User::destroy($userId);

            // Seed Mail
            $mail = new Mail();
            $mail->seed('default', $userInformations->mail, array(
                'subject'     => 'Deleted account',
                'contentHtml' => "Your account has been delete by an administrator of the Mydropper.io"
            ));

            $this->fMessage->set('The account is deleted', 'alert');
            $this->f3->reroute('/admin/users');
        } else {
            $this->f3->reroute('/admin/users');
        }
    }

}