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
class FormCategory extends Eloquent {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'form_categories';
	protected $guarded = array();

	public static $rules = array(
            'name' => 'alpha_spaces|required|unique:form_categories,name'
        );

    /**
     * Relation with built_forms table
     * Many forms can belong to a form category
     */
    public function forms()
    {
        return $this->hasMany('BuiltForm', 'category');
    }

    public static function validate($input, $id=false)
    {
        if ($id) {
            static::$rules['name'] .= ','.$id;
        }
        return Validator::make($input, static::$rules);
    }

    /**
     * Get all form categories in id=>name format
     * @return array
     */
    public static function all_categories()
    {
        $ret = array('Select Category');
        foreach (FormCategory::all() as $form_cat) {
            $ret[$form_cat->id] = $form_cat->name;
        }
        return $ret;
    }
}
