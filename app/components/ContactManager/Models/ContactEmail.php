<?php namespace Components\ContactManager\Models;
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
