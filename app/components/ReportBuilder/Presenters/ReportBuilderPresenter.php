<?php namespace Components\ReportBuilder\Presenters;
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

class ReportBuilderPresenter extends Presenter
{
    /**
     * Get the page's author
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
     * Get the page's editor
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
