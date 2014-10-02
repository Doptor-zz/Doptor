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

class BuiltForm extends Eloquent {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'built_forms';

    protected $guarded = array('id');

    public static $rules = array(
            'name'     => 'alpha_spaces|required',
            'hash'     => 'unique:built_forms,hash',
            'category' => 'required|not_in:0',
            'data'     => 'required'
        );

    /**
     * Relation with the form categories table
     * A post can have only one form category
     */
    public function cat()
    {
         return $this->belongsTo('FormCategory', 'category', 'id');
    }

    /**
     * Validation during create/update of forms
     * @param  array $input Input received from the form
     * @return Validator
     */
    public static function validate($input, $id=false)
    {
        if ($id) {
            static::$rules['hash'] .= ','.$id;
        }
        return Validator::make($input, static::$rules);
    }

    /**
     * All forms with their categories
     * @return array
     */
    public static function all_forms()
    {
        $forms = array(0=>'None');
        $categories = BuiltForm::get(array('category'));

        foreach ($categories as $category) {
            $names = array();
            foreach (BuiltForm::where('category', '=', $category->category)->get(array('id', 'name')) as $form) {
                // Get only the form names
                $names[$form->id] = $form->name;
            }
            $forms[FormCategory::find($category->category)->name] = $names;
        }

        return $forms;
    }

    /**
     * Get all where to redirect to
     * @return array
     */
    public static function redirect_to()
    {
        $ret = array(
                'list'   => 'List Records',
                'add'    => 'Add Records',
                // 'manual' => 'Enter link manually'
            );
        return $ret;
    }

}
