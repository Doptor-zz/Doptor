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

use Components\ContactManager\Presenters\ContactPresenter;
use Robbo\Presenter\PresentableInterface;

class ContactDetail extends Eloquent implements PresentableInterface {

	protected $table = 'contact_details';

	protected $fillable = array('name', 'alias', 'image', 'email', 'address', 'city', 'state', 'zip_code', 'category_id', 'country', 'telephone', 'mobile', 'fax', 'website', 'display_options', 'location');
	protected $guarded = array('id');

    public function emails()
    {
        return $this->hasMany('Components\\ContactManager\\Models\\ContactEmail', 'contact_id');
    }

    public function category()
    {
        return $this->belongsTo('Components\\ContactManager\\Models\\ContactCategory', 'category_id');
    }

    /**
     * Automatically set the alias, if one is not provided
     * @param string $alias
     */
    public function setAliasAttribute($alias)
    {
        if ($alias == '') {
            $alias = Str::slug($this->attributes['name']);
            $aliases = $this->whereRaw("alias REGEXP '^{$alias}(-[0-9]*)?$'");

            if ($aliases->count() === 0) {
                $this->attributes['alias'] = $alias;
            } else {
                // get reverse order and get first
                $lastAliasNumber = intval(str_replace($alias . '-', '', $aliases->orderBy('alias', 'desc')->first()->alias));

                $this->attributes['alias'] = $alias . '-' . ($lastAliasNumber + 1);
            }
        } else {
            $this->attributes['alias'] = $alias;
        }
    }

    /**
     * Initiate the presenter class
     */
    public function getPresenter()
    {
        return new ContactPresenter($this);
    }

}
