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

class MenuCategoryPresenter extends Presenter
{

    /**
     * Get the page's location
     * @return string
     */
    public function location()
    {
        if (array_key_exists($this->menu_type, MenuCategory::$menu_positions)) {
            return MenuCategory::$menu_positions[$this->menu_type];
        } else {
            return $this->menu_type;
        }
    }

}
