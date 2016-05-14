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

class Company extends Eloquent {

	protected $table = 'mdl_doptor_companies';

	protected $fillable = array('name', 'reg_no', 'logo', 'address', 'country_id', 'website', 'phone', 'email', 'address', 'captcha');
	protected $guarded = array('id');

    /**
     * A company can belong to one country
     */
    public function country()
    {
        return $this->belongsTo('Modules\Doptor\CompanyInfo\Models\Country');
    }

    /**
     * A company have many branches
     */
    public function branches()
    {
        return $this->hasMany('Modules\Doptor\CompanyInfo\Models\CompanyBranch');
    }

    /**
     * Get the company incharges.
     */
    public function incharges()
    {
        return $this->morphMany('Modules\Doptor\CompanyInfo\Models\PersonInCharge', 'inchargable');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($entry) {
            if (!$entry->isValid()) return false;
        });

        static::updating(function($entry) {
            if (!$entry->isValid()) return false;
        });
    }

    public function isValid()
    {
        $entry = $this->toArray();

        $rules = [
            'name' => 'required',
            'reg_no' => 'required',
            'country_id' => 'not_in:0'
        ];

        $messages = [
            'country_id.not_in' => 'Select a country'
        ];

        $validation = Validator::make($entry, $rules, $messages);

        if ($validation->fails()) throw new ValidationException($validation->messages());

        return true;
    }

    public static function names()
    {
        $countries = static::lists('name', 'id')->all();
        $countries[0] = 'Select Company';
        ksort($countries);

        return $countries;
    }

}
