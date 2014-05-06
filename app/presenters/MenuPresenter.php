<?php
/*
=================================================
CMS Name  :  DOPTOR
CMS Version :  v1.2
Available at :  www.doptor.org
Copyright : Copyright (coffee) 2011 - 2014 Doptor. All rights reserved.
License : GNU/GPL, visit LICENSE.txt
Description :  Doptor is Opensource CMS.
===================================================
*/
use Robbo\Presenter\Presenter;

class MenuPresenter extends Presenter
{
    /**
     * Get the page's status
     * @return string
     */
    public function status()
    {
        return Str::title($this->status);
    }

    public function wrapper_width()
    {
        return ($this->wrapper_width) ?: '100%';
    }

    public function wrapper_height()
    {
        return ($this->wrapper_height) ?: '500px';
    }

    /**
     * Get the menu's author
     * @return string
     */
    public function author()
    {
        try {
            $user = Sentry::findUserById($this->created_by);
            return $user->username;
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return '';
        }
    }

    /**
     * Get the menu's editor
     * @return string
     */
    public function editor()
    {
        if ($this->updated_by == null) {
            return '';
        }
        try {
            $user = Sentry::findUserById($this->updated_by);
            return $user->username;
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return '';
        }
    }
}
