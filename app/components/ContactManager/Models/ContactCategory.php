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
use App;
use Eloquent;
use Str;

use Components\ContactManager\Presenters\ContactCategoryPresenter;
use Robbo\Presenter\PresentableInterface;

class ContactCategory extends Eloquent implements PresentableInterface {
    protected $table = 'contact_categories';

    protected $guarded = array('id');
    public static $rules = array();

    /**
     * Relation with contacts table
     */
    public function contacts()
    {
        return $this->hasMany('Components\\ContactManager\\Models\\ContactDetail', 'category_id');
    }

    /**
     * When creating a contact, run the attributes through a validator first.
     * @param array $attributes
     * @return void
     */
    public static function create(array $attributes = array())
    {
        App::make('Components\\ContactManager\\Validation\\ContactCategoryValidator')->validateForCreation($attributes);
        $attributes['created_by'] = current_user()->id;

        return parent::create($attributes);
    }

    /**
     * When updating a contact, run the attributes through a validator first.
     * @param array $attributes
     * @return void
     */
    public function update(array $attributes = array())
    {
        App::make('Components\\ContactManager\\Validation\\ContactCategoryValidator')->validateForUpdate($attributes);
        $attributes['updated_by'] = current_user()->id;

        return parent::update($attributes);
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
     * Get all the published contacts that are within the publish date range
     * @return query
     */
    public function scopePublished($query)
    {
        return $query->where('status', '=', 'published');
    }

    /**
     * Get all the statuses available for a contact
     * @return array
     */
    public static function all_status()
    {
        return array(
                'published'   => 'Publish',
                'unpublished' => 'Unpublish',
                'drafted'     => 'Draft',
                'archived'    => 'Archive'
            );
    }

    /**
     * Initiate the presenter class
     */
    public function getPresenter()
    {
        return new ContactCategoryPresenter($this);
    }
}
