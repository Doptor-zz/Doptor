<?php namespace Components\ContactManager\Models;
/*
=================================================
Module Name     :   Contact Manager
Module Version  :   v0.1
Compatible CMS  :   v1.2
Site            :
Description     :
===================================================
*/
use Eloquent;
use Str;

class ContactEmail extends Eloquent {

    protected $table = 'contact_emails';

    protected $guarded = array('id');

    public function contact()
    {
        return $this->belongsTo('Components\\ContactManager\\Models\\ContactDetail');
    }

}
