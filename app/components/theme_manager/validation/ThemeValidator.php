<?php namespace Components\ThemeManager\Validation;
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
use Services\Validation\Validator as Validator;

class ThemeValidator extends Validator {

    /**
     * Default rules
     * @var array
     */
    protected $rules = array(
        'file' => 'image|max:3000',
    );

    /**
     * Default rules for update
     * @var array
     */
    protected $updateRules = array(
        'file' => 'image|max:3000',
    );

    /**
     * Messages for validation
     * @var array
     */
    protected $message = array(
    );
}
