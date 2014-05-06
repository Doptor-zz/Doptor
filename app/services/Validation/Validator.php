<?php namespace Services\Validation;
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
use Validator as V;

abstract class Validator {

    /**
     * Perform validation
     *
     * @param $input
     * @param $rules
     *
     * @return bool
     * @throws ValidationException
     */
    public function validate($input, $rules, $message=array())
    {
        $validation = V::make($input, $rules, $message);

        if ($validation->fails()) throw new ValidationException($validation->messages());

        return true;
    }

    /**
     * Validate against default ruleset
     *
     * @param $input
     *
     * @return bool
     */
    public function validateForCreation($input)
    {
        return $this->validate($input, $this->rules, $this->message);
    }

    /**
     * Validate against update ruleset
     *
     * @param $input
     *
     * @return bool
     */
    public function validateForUpdate($input)
    {
        return $this->validate($input, $this->updateRules, $this->message);
    }
}
