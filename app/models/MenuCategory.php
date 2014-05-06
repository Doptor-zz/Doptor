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
use Robbo\Presenter\PresentableInterface;

class MenuCategory extends Eloquent implements PresentableInterface {
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'menu_categories';

	protected $guarded = array();

	public static $rules = array(
            'name'      => 'alpha_spaces|required|unique:menu_categories,name',
            'menu_type' => 'required|unique:menu_categories,menu_type'
        );

    public static $menu_positions = array(
                'public-small-menu-left'  => 'Public Small Menu Left',
                'public-small-menu-right' => 'Public Small Menu Right',
                'public-top-menu'         => 'Public Top Menu',
                'public-bottom-menu'      => 'Public Bottom Menu',
                'admin-top-menu'          => 'Admin Top Menu',
                'admin-main-menu'         => 'Admin Menu Menu',
            );

    /**
     * Relation with menus table
     */
    public function menus()
    {
        return $this->hasMany('Menu', 'category');
    }

    public static function validate($input, $id=false)
    {
        if ($id) {
            static::$rules['name']      .= ','.$id;
            static::$rules['menu_type'] .= ','.$id;
        }
        return Validator::make($input, static::$rules);
    }

    public static function menu_positions()
    {
        return static::$menu_positions;
    }

    /**
     * Initiate the presenter class
     */
    public function getPresenter()
    {
        return new MenuCategoryPresenter($this);
    }
}
