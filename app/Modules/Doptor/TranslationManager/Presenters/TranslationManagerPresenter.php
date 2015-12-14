<?php namespace Modules\Doptor\TranslationManager\Presenters;
/*
=================================================
CMS Name  :  DOPTOR
CMS Version :  v1.2
Available at :  www.doptor.org
Copyright : Copyright (coffee) 2011 - 2015 Doptor. All rights reserved.
License : GNU/GPL, visit LICENSE.txt
Description :  Doptor is Opensource CMS.
===================================================
*/
use Str;

use Sentry;
use Cartalyst\Sentry\Users\UserNotFoundException;

use Robbo\Presenter\Presenter;

class TranslationManagerPresenter extends Presenter
{
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
}
