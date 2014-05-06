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
class Group extends Eloquent {
	protected $guarded = array();

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'groups';

    public static $rules = array(
            'name'     => 'alpha_spaces|required|unique:groups,name'
        );

    /**
     * Validation during create/update of groups
     * @param  array $input Input received from the form
     * @return Validator
     */
    public static function validate($input, $id=false)
    {
        if ($id) {
            static::$rules['name'] .= ','.$id;
        }
        return Validator::make($input, static::$rules);
    }

	/**
     * Relation with the menus table
     * A user group can have many menus
     */
    public function menus()
    {
        return $this->belongsToMany('Menu');
    }
}
