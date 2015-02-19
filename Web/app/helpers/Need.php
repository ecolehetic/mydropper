<?php

namespace APP\HELPERS;

use APP\MODELS\User;

/**
 * Class Need
 * @package APP\HELPERS
 */
class Need extends BaseHelper
{

    const LOGGED                = 'logged';
    const UNLOGGED              = 'unlogged';
    const LEVEL                 = 'level';
    const UNLOGGED_MESSAGE      = "Vous ne pouvez pas accéder à cette page étant connecté.";
    const LOGGED_MESSAGE        = "Vous devez être connecté pour accéder à cette page.";
    const LEVEL_MESSAGE         = "Vous n'avez pas le level minimum pour accéder à cette page.";

    private $choose     = null;
    private $redirect   = null;
    private $user       = null;
    private $level      = null;

    /**
     * Register the choose and add Path in the instance
     *
     * @param string $path
     *
     * @return $this
     */
    public function logged($path)
    {
        $this->choose = self::LOGGED;
        $this->redirect = $path;

        return $this;
    }

    /**
     * Register the choose and add Path in the instance
     *
     * @param string $path
     *
     * @return $this
     */
    public function unLogged($path)
    {
        $this->choose = self::UNLOGGED;
        $this->redirect = $path;

        return $this;
    }

    /*
     * Minimum Level
     * Use for Admin page
     *
     * @param int $level
     *
     * @return $this
     */
    public function minimumLevel($level)
    {
        $this->level = $level;

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
    public function testLogged()
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
        switch($value){
            case self::LOGGED:
                $fMessage->set(self::LOGGED_MESSAGE);
                break;
            case self::UNLOGGED:
                $fMessage->set(self::UNLOGGED_MESSAGE);
                break;
            case self::LEVEL:
                $fMessage->set(self::LEVEL_MESSAGE);
                break;
            default: break;
        }
        $this->f3->reroute($this->redirect, true);
    }

    /*
     * Check if the user have the minimum level Required
     *
     * @param int $level
     */
    private function checkLevel($level)
    {
        if($this->testLogged() === false){
            $user = $this->f3->get('SESSION.user');
            $role = User::find($user->id)->roles()->get();

            if($role->level > $level){
                return true;
            }
            else{
                return false;
            }

        }
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

        if($this->level !== null){
            if($this->checkLevel($this->level) === false){
                $this->error(self::LEVEL);
                return;
            }
        }


        if($this->user === true && $this->testLogged() === false){
            return $this->f3->get('SESSION.user');
        }
    }

}