<?php namespace Admin;
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
class HomeController extends AdminController {

    /**
     * Index page of admin dashboard
     * @return View
     */
    public function getIndex()
    {
        $this->layout->title = 'Home';
        $this->layout->content = \View::make('admin.'.$this->current_theme.'.index');
    }

    /**
     * Configuration of the website
     * @return View
     */
    public function getConfig()
    {
        $this->layout->title = 'Website Configuration';
        $this->layout->content = \View::make('admin.'.$this->current_theme.'.config');
    }
}
