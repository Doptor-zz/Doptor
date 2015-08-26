<?php
/*
=================================================
CMS Name  :  DOPTOR
CMS Version :  v1.2
Available at :  www.doptor.org
Copyright : Copyright (coffee) 2011 - 2015 Doptor. All rights reserved.
License : GNU/GPL, visit LICENSE.txt
Description :  Doptor is Opensource CMS.
===================================================
*/
use Robbo\Presenter\PresentableInterface;

class BuiltModule extends Eloquent implements PresentableInterface {
    protected $fillable = array('name', 'hash', 'version', 'author', 'vendor', 'website', 'description', 'form_id', 'target', 'file', 'requires', 'table_name', 'is_author');
    protected $guarded = array('id', 'confirmed');

	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'built_modules';

    public static $rules = array(
            'name'    => 'alpha_spaces|required|unique_vendor_modulename:built_modules',
            'hash'    => 'unique:built_modules,hash',
            'version' => 'required',
            'author'  => 'required',
            'vendor'  => 'required|alpha_num',
            'target'  => 'required'
        );

    public static $message = array(
            'unique_vendor_modulename' => 'The combination of vendor and module name must be unique'
        );

    /**
     * Validation during create/update of modules
     * @param  array $input Input received from the form
     * @return Validator
     */
    public static function validate($input, $id=false)
    {
        static::$rules['name'] .= ',vendor,' . $input['vendor'];
        if ($id) {
            $built_module = static::find($id);
            if (!(bool) $built_module->is_author) {
                // If the current system is not author, then author
                // info is not required
                unset(static::$rules['name']);
                unset(static::$rules['version']);
                unset(static::$rules['author']);
            } else {
                static::$rules['name'] .= ',' . $id;
            }
        }

        return Validator::make($input, static::$rules, static::$message);
    }

    /**
     * Show only visible built modules
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
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

    public function required_modules()
    {
        return json_decode($this->requires);
    }

    /**
     * Initiate the presenter class
     */
    public function getPresenter()
    {
        return new BuiltModulePresenter($this);
    }
}
