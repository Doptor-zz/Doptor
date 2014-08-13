<?php namespace Components\ReportBuilder\Models;
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

use Robbo\Presenter\PresentableInterface;

use Components\ReportBuilder\Presenters\ReportBuilderPresenter;

class BuiltReport extends Eloquent implements PresentableInterface {

    protected $table = 'built_reports';

    protected $fillable = array('name', 'author', 'version', 'website', 'modules', 'show_calendars', 'created_by', 'updated_by');

    protected $guarded = array('id');

    public static function create(array $attributes = array())
    {
        $attributes['modules'] = json_encode($attributes['modules']);
        $attributes['created_by'] = current_user()->id;

        return parent::create($attributes);
    }

    public function update(array $attributes = array())
    {
        $attributes['modules'] = json_encode($attributes['modules']);
        $attributes['updated_by'] = current_user()->id;

        return parent::update($attributes);
    }

    public function setRequiredFieldsAttribute($fields)
    {
        $this->attributes['required_fields'] = json_encode($fields);
    }

    public function setShowCalendarsAttribute($show_calendars)
    {
        $this->attributes['show_calendars'] = $show_calendars;
    }

    public function getModulesAttribute()
    {
        return json_decode($this->attributes['modules'], true);
    }

    public function getShowCalendarsAttribute()
    {
        return (boolean)$this->attributes['show_calendars'];
    }

    /**
     * Initiate the presenter class
     */
    public function getPresenter()
    {
        return new ReportBuilderPresenter($this);
    }
}
