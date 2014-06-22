<?php namespace Modules\Slideshow\Validation;
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

class SlideshowValidator extends Validator {

    /**
     * Default rules
     * @var array
     */
    protected $rules = array(
        'image'     => 'alpha_spaces|required'
    );

    /**
     * Default rules for update
     * @var array
     */
    protected $updateRules = array(
        // 'image'     => 'required'
    );

    /**
     * Messages for validation
     * @var array
     */
    protected $message = array(
    );

    public function validateForCreation($input)
    {
        /*if ($input['publish_start'] != '' && $input['publish_end'] != '') {
            $this->rules['publish_start'] = 'before:'.$input['publish_end'];
            $this->rules['publish_end'] = 'after:'.$input['publish_start'];
        }*/

        return $this->validate($input, $this->rules, $this->message);
    }

    public function validateForUpdate($input)
    {
        /*if ($input['publish_start'] != '' && $input['publish_end'] != '') {
            $this->updateRules['publish_start'] = 'before:'.$input['publish_end'];
            $this->updateRules['publish_end'] = 'after:'.$input['publish_start'];
        }*/

        return $this->validate($input, $this->updateRules, $this->message);
    }
}
