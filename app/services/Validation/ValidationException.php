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
use Exception;

class ValidationException extends Exception {

    /**
     * Validation errors
     *
     * @var MessageBag
     */
    protected $errors;

    /**
     * Constructor
     *
     * @param MessageBag    $errors
     * @param string    $message
     * @param int       $code
     * @param Exception $previous
     */
    public function __construct($errors, $message = '', $code = 0, Exception $previous = null)
    {
        $this->errors = $errors;

        parent::__construct($message, $code, $previous);
    }

    /**
     * Get validation errors
     *
     * @return MessageBag
     */
    public function getErrors()
    {
        return $this->errors;
    }

}
