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

class ThemePresenter extends Presenter
{
    /**
     * Get the creation date of the theme_entry
     * @return string
     */
    public function date()
    {
        return $this->created_at->format('d') . '<br>' . $this->created_at->format('M') . '<br>' . $this->created_at->format('Y');
    }

    public function status()
    {
        if (Setting::value("{$this->target}_theme") == $this->id) {
            return 'Applied';
        } else {
            return 'Not Applied';
        }
    }
}
