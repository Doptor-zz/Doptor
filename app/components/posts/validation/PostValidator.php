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

class PostValidator extends Validator {

    /**
     * Default rules
     * @var array
     */
    protected $rules = array(
        'title'     => 'alpha_spaces|required',
        'permalink' => 'unique:posts,permalink',
        // 'image'     => 'image',
        // 'content'   => 'required',
        'status'    => 'required'
    );

    /**
     * Default rules for update
     * @var array
     */
    protected $updateRules = array(
        'title'     => 'alpha_spaces|required',
        'permalink' => 'unique:posts,permalink',
        // 'image'  => 'image',
        // 'content'   => 'required',
        'status'    => 'required'
    );

    /**
     * Messages for validation
     * @var array
     */
    protected $message = array(
        'permalink.unique' => 'The alias has already been taken'
    );

    public function validateForCreation($input)
    {
        if ($input['publish_start'] != '' && $input['publish_end'] != '') {
            $this->rules['publish_start'] = 'before:'.$input['publish_end'];
            $this->rules['publish_end'] = 'after:'.$input['publish_start'];
        }

        return $this->validate($input, $this->rules, $this->message);
    }

    public function validateForUpdate($input)
    {
        $this->updateRules['permalink'] .= ',' . $input['id'];

        if ($input['publish_start'] != '' && $input['publish_end'] != '') {
            $this->updateRules['publish_start'] = 'before:'.$input['publish_end'];
            $this->updateRules['publish_end'] = 'after:'.$input['publish_start'];
        }

        return $this->validate($input, $this->updateRules, $this->message);
    }
}
