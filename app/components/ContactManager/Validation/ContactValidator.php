<?php namespace Components\ContactManager\Validation;
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

class ContactValidator extends Validator {

    /**
     * Default rules
     * @var array
     */
    protected $rules = array(
        'name'       => 'required',
    );

    /**
     * Default rules for update
     * @var array
     */
    protected $updateRules = array(
        'name'       => 'required',
    );

    /**
     * Messages for validation
     * @var array
     */
    protected $message = array(
        'alias.unique' => 'The alias has already been taken'
    );

    public function validateForCreation($input)
    {
        return $this->validate($input, $this->rules, $this->message);
    }

    public function validateForUpdate($input)
    {
        $this->updateRules['alias'] .= ',' . $input['id'];

        return $this->validate($input, $this->updateRules, $this->message);
    }
}
