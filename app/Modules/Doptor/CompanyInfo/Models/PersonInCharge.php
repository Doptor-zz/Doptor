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

class PersonInCharge extends Eloquent {

    protected $table = 'mdl_doptor_incharges';

    protected $guarded = array('id');

    /**
     * Get all of the owning inchargable models.
     */
    public function inchargable()
    {
        return $this->morphTo();
    }

    /**
     * A company can belong to one country
     */
    public function country()
    {
        return $this->belongsTo('Modules\Doptor\CompanyInfo\Models\Country');
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
            'country_id' => 'not_in:0'
        ];

        $messages = [
            'country_id.not_in' => 'Select a country'
        ];

        $validation = Validator::make($entry, $rules, $messages);

        if ($validation->fails()) throw new ValidationException($validation->messages());

        return true;
    }

}
