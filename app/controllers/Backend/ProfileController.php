<?php namespace Backend;
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
class ProfileController extends AdminController {

    public function showProfile()
    {
        $this->layout->title = 'User Information';
        $this->layout->content = \View::make($this->link_type.'.'.$this->current_theme.'.users.show')
                                        ->with('user', $this->user);
    }

    public function editProfile()
    {
    	$this->layout->title = 'Edit Profile';
        $this->layout->content = \View::make($this->link_type.'.'.$this->current_theme.'.users.create_edit')
        								->with('title', 'Edit Profile')
        								->with('user', $this->user);
    }

}
