<?php namespace Modules\Doptor\CompanyInfo\Models;
/*
=================================================
Module Name     :   Company Info
Module Version  :   v1.0
Compatible CMS  :   v1.2
Site            :   http://doptor.net
Description     :
===================================================
*/
use Eloquent;
use Validator;

use Services\Validation\ValidationException as ValidationException;

class Country extends Eloquent {

    protected $table = 'mdl_doptor_countries';

    public static function names()
    {
        $countries = static::lists('name', 'id')->all();
        $countries[0] = 'Select Country';
        ksort($countries);

        return $countries;
    }
}
