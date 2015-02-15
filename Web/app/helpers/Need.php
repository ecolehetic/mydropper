<?php

namespace APP\HELPERS;

/**
 * Class Need
 * TODO Add Role rules
 * @package APP\HELPERS
 */
class Need extends BaseHelper
{

    const LOGGED = 'logged';
    const UNLOGGED = 'unlogged';
    const UNLOGGED_MESSAGE = "Vous ne pouvez pas accéder à cette page étant connecté.";
    const LOGGED_MESSAGE = "Vous devez être connecté pour accéder à cette page";

    private $choose = null;
    private $redirect = null;
    private $user = null;

    /**
     * Register the choose and add Path in the instance
     *
     * @param $path
     *
     * @return $this
     */
    public function logged($path)
    {
        $this->choose = 'logged';
        $this->redirect = $path;

        return $this;
    }

    /**
     * Register the choose and add Path in the instance
     *
     * @param $path
     *
     * @return $this
     */
    public function unLogged($path)
    {
        $this->choose = 'unlogged';
        $this->redirect = $path;

        return $this;
    }

    /**
     * Register if need userInformation
     *
     * @return $this
     */
    public function user()
    {
       $this->user = true;

       return $this;
    }

    /**
     * Test if user is logged
     *
     * @return bool
     */
    private function testLogged()
    {
        $user = $this->f3->get('SESSION.user');

        if ($user === null || empty($user)) {
            return true;
        }

        return false;
    }

    /**
     * If error, so add a FlashMessage and redirect the user
     *
     * @param $value
     */
    private function error($value)
    {
        $fMessage = new FlashMessage();
        $fMessage->set(($value === self::LOGGED) ? self::LOGGED_MESSAGE : self::UNLOGGED_MESSAGE);
        $this->f3->reroute($this->redirect, true);
    }

    /**
     * Execute Command
     */
    public function execute()
    {
        if($this->choose === self::LOGGED && $this->testLogged() === true){
            $this->error(self::LOGGED);
            return;
        }
        if($this->choose === self::UNLOGGED && $this->testLogged() === false){
            $this->error(self::UNLOGGED);
            return;
        }
        if($this->user === true && $this->testLogged() === false){
            return $this->f3->get('SESSION.user');
        }
    }

}