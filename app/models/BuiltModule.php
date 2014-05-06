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

class BuiltModule extends Eloquent implements PresentableInterface {
    protected $fillable = array('name', 'version', 'author', 'website', 'description', 'form_id', 'target', 'file', 'table_name');
    protected $guarded = array('confirmed');

	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'built_modules';

    public static $rules = array(
            'name'       => 'alpha_spaces|required|unique:built_modules,name',
            'version'    => 'required',
            'author'     => 'required',
            'form-1'     => 'required|not_in:0',
            'target'     => 'required',
            'table_name' => 'required'
        );

    public static $message = array(
            'form-1.not_in' => 'At least the first form is required'
        );

    /**
     * Validation during create/update of modules
     * @param  array $input Input received from the form
     * @return Validator
     */
    public static function validate($input, $id=false)
    {
        if ($id) {
            static::$rules['name'] .= ',' . $id;
        }
        return Validator::make($input, static::$rules, static::$message);
    }

    /**
     * Get all the targets available for a module-builder
     * @return array
     */
    public static function all_targets()
    {
        return array(
                'public'  => 'Public',
                'admin'   => 'Admin',
                'backend' => 'Backend'
            );
    }

    public function selected_targets()
    {
        return explode(', ', $this->target);
    }

    /**
     * Initiate the presenter class
     */
    public function getPresenter()
    {
        return new BuiltModulePresenter($this);
    }
}
