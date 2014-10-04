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

	protected $guarded = array('id');

	public static $rules = array(
            'name'  => 'alpha_spaces|required|unique:menu_categories,name',
            'alias' => 'required|unique:menu_categories,alias'
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
            static::$rules['name']  .= ','.$id;
            static::$rules['alias'] .= ','.$id;
        }
        return Validator::make($input, static::$rules);
    }

    /**
     * Automatically set the alias, if one is not provided
     * @param string $alias
     */
    public function setAliasAttribute($alias)
    {
        if ($alias == '') {
            $alias = Str::slug($this->attributes['name']);
            $aliases = $this->whereRaw("alias REGEXP '^{$alias}(-[0-9]*)?$'");

            if ($aliases->count() === 0) {
                $this->attributes['alias'] = $alias;
            } else {
                // get reverse order and get first
                $lastAliasNumber = intval(str_replace($alias . '-', '', $aliases->orderBy('alias', 'desc')->first()->alias));

                $this->attributes['alias'] = $alias . '-' . ($lastAliasNumber + 1);
            }
        } else {
            $this->attributes['alias'] = $alias;
        }
    }

    /**
     * Initiate the presenter class
     */
    public function getPresenter()
    {
        return new MenuCategoryPresenter($this);
    }
}
