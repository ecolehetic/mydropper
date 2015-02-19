<?php

namespace APP\CONTROLLERS;

class ProfileController extends BaseController
{
    /*
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