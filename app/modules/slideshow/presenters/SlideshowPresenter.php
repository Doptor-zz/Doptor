<?php namespace Modules\Slideshow\Presenters;
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
use Str;

use Sentry;
use Cartalyst\Sentry\Users\UserNotFoundException;

use Robbo\Presenter\Presenter;

class SlideshowPresenter extends Presenter
{

    /**
     * Get the page's status
     * @return string
     */
    public function status()
    {
        return Str::title($this->status);
    }

    /**
     * Get the slideshow's author
     * @return string
     */
    public function author()
    {
        try {
            $user = Sentry::findUserById($this->created_by);
            return $user->username;
        } catch (UserNotFoundException $e) {
            return '';
        }
    }

    /**
     * Get the slideshow's editor
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
        } catch (UserNotFoundException $e) {
            return '';
        }
    }
}
