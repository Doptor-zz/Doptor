<?php namespace Components\Posts\Validation;
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

class CategoryValidator extends Validator {

    /**
     * Default rules
     * @var array
     */
    protected $rules = array(
        'name'     => 'required|unique:categories,name',
        'alias' => 'alpha_spaces|unique:categories,alias',
    );

    /**
     * Default rules for update
     * @var array
     */
    protected $updateRules = array(
        'name'     => 'required|unique:categories,name',
        'alias' => 'alpha_spaces|unique:categories,alias',
    );

    /**
     * Messages for validation
     * @var array
     */
    protected $message = array(
    );

    public function validateForUpdate($input)
    {
        $this->updateRules['name'] .= ',' .$input['id'];
        $this->updateRules['alias'] .= ',' . $input['id'];

        return $this->validate($input, $this->updateRules, $this->message);
    }
}
