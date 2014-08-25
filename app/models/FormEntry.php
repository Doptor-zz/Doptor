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
use Services\Validation\ValidationException as ValidationException;

class FormEntry extends Eloquent implements PresentableInterface {
	protected $fillable = array('form_id', 'fields', 'data');

    protected $guarded = array('id');

    protected $table = 'form_entries';

    public static function create(array $attributes = array())
    {
        // dd($attributes);
        static::isValid($attributes);

        if (isset($attributes['captcha'])) {
            // Do not save the value of captcha to database
            unset($attributes['captcha']);
        }
        unset($attributes['_token']);

        $entry['form_id'] = $attributes['form_id'];
        unset($attributes['form_id']);

        $form = BuiltForm::findOrFail($entry['form_id']);

        $module_builder = new Services\ModuleBuilder;
        $form_fields = $module_builder->getFormFields($form->data);

        $fields = array_combine($form_fields['fields'], $form_fields['field_names']);

        $entry['data'] = json_encode($attributes);
        $entry['fields'] = json_encode($fields);
        // dd($entry);
        return parent::create($entry);
    }

    public static function isValid($attributes)
    {
        $rules = array();

        $messages = array();

        if (isset($attributes['captcha'])) {
            $rules['captcha'] = 'required|captcha';
            $messages['captcha.captcha'] = 'Incorrect captcha';
        }

        $validation = Validator::make($attributes, $rules, $messages);

        if ($validation->fails()) throw new ValidationException($validation->messages());

        return true;
    }

    /**
     * Initiate the presenter class
     */
    public function getPresenter()
    {
        return new FormEntryPresenter($this);
    }
}
