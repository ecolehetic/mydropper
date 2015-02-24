<?php

namespace MyDropper\Helpers;

use MyDropper\Models\User;

/**
 * Class Need
 * @package MyDropper\Helpers
 */
class Need extends BaseHelper
{

    const LOGGED           = 'logged';
    const UNLOGGED         = 'unlogged';
    const LEVEL            = 'level';
    const UNLOGGED_MESSAGE = "You cannot reach this page being connected.";
    const LOGGED_MESSAGE   = "You must be connected to reach this page.";
    const LEVEL_MESSAGE    = "You have no minimum level to reach this page.";

    private $choose   = null;
    private $redirect = null;
    private $user     = null;
    private $level    = null;

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

    /**
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
                $fMessage->set(self::LOGGED_MESSAGE, 'error');
                break;
            case self::UNLOGGED:
                $fMessage->set(self::UNLOGGED_MESSAGE, 'error');
                break;
            case self::LEVEL:
                $fMessage->set(self::LEVEL_MESSAGE, 'error');
                break;
            default: break;
        }
        $this->f3->reroute($this->redirect, true);
    }

    /**
     * Check if the user have the minimum level Required
     *
     * @param int $level
     *
     * @return bool
     */
    private function checkLevel($level)
    {
        if($this->testLogged() === false){
            $user = $this->f3->get('SESSION.user');
            $role = User::find($user->id)->roles()->get();

            if($role[0]->level >= $level){
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
            return false;
        }

        if($this->choose === self::UNLOGGED && $this->testLogged() === false){
            $this->error(self::UNLOGGED);
            return false;
        }

        if($this->level !== null){
            if($this->checkLevel($this->level) === false){
                $this->error(self::LEVEL);
                return false;
            }
        }


        if($this->user === true && $this->testLogged() === false){
            return $this->f3->get('SESSION.user');
        }
    }

}