<?php namespace Modules\Newsletter\Validation;

use Services\Validation\Validator as Validator;

class SubscriberValidator extends Validator
{

    /**
     * Default rules
     * @var array
     */
    protected $rules = array(
        'email' => 'required|email|unique:newsletter_subscribers,email'
    );

    /**
     * Default rules for update
     * @var array
     */
    protected $updateRules = array(
        'email' => 'required|email|unique:newsletter_subscribers,email'
    );

    /**
     * Messages for validation
     * @var array
     */
    protected $message = array(
        'email.unique' => 'The email is already subscribed to the newsletter'
    );

    public function validateForUpdate($input)
    {
        $this->updateRules['email'] .= ',' . $input['id'];

        return $this->validate($input, $this->updateRules, $this->message);
    }
}
