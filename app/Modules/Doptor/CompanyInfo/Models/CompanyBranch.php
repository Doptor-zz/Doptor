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

class CompanyBranch extends Eloquent {

    protected $table = 'mdl_doptor_company_branches';

    protected $fillable = array('name', 'reg_no', 'country_id', 'address', 'website', 'phone', 'fax', 'mobile', 'email', 'company_id');
    protected $guarded = array('id');

    /**
     * A company branch can belong to one country
     */
    public function country()
    {
        return $this->belongsTo('Modules\Doptor\CompanyInfo\Models\Country');
    }

    /**
     * A company branch can belong to one company
     */
    public function company()
    {
        return $this->belongsTo('Modules\Doptor\CompanyInfo\Models\Company');
    }

    /**
     * Get the branch incharge.
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
            'country_id' => 'not_in:0',
            'company_id' => 'not_in:0',
        ];

        $messages = [
            'country_id.not_in' => 'Select a country',
            'company_id.not_in' => 'Select a company',
        ];

        $validation = Validator::make($entry, $rules, $messages);

        if ($validation->fails()) throw new ValidationException($validation->messages());

        return true;
    }

}
