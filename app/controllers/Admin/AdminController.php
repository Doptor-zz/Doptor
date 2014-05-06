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
class AdminController extends \BaseController {

    protected $user;

    /**
     * The layout that should be used for responses.
     */
    protected $layout = 'admin.'.$this->current_theme.'._layouts._layout';
}
