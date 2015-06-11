<?php namespace Modules\ModuleName\Models;
/*
=================================================
Module Name     :   NameOfTheModule
Module Version  :   vVersionOfTheModule
Compatible CMS  :   v1.2
Site            :   WebsiteOfTheModule
Description     :   DescriptionOfTheModule
===================================================
*/
use Eloquent;
use Validator;

use Services\Validation\ValidationException as ValidationException;

class ModuleModel extends Eloquent {

	protected $table = 'table_name';

	protected $fillable = array(table_fields, 'captcha');
	protected $guarded = array('id');

    public static function boot()
    {
        parent::boot();

        static::creating(function($entry) {
            if (!$entry->isValid()) return false;
            if (isset($entry['captcha'])) {
                // Do not save the value of captcha to database
                unset($entry['captcha']);
            }
        });

        static::updating(function($entry) {
            if (!$entry->isValid()) return false;
            if (isset($entry['captcha'])) {
                // Do not save the value of captcha to database
                unset($entry['captcha']);
            }
        });
    }

    public function isValid()
    {
        $entry = $this->toArray();

        $rules = array();

        $messages = array();

        if (isset($entry['captcha'])) {
            $rules['captcha'] = 'required|captcha';
            $messages['captcha.captcha'] = 'Incorrect captcha';
        }

        $validation = Validator::make($entry, $rules, $messages);

        if ($validation->fails()) throw new ValidationException($validation->messages());

        return true;
    }

}
