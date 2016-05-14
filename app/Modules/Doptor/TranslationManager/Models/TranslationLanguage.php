<?php namespace Modules\Doptor\TranslationManager\Models;
/*
=================================================
CMS Name  :  DOPTOR
CMS Version :  v1.2
Available at :  www.doptor.org
Copyright : Copyright (coffee) 2011 - 2015 Doptor. All rights reserved.
License : GNU/GPL, visit LICENSE.txt
Description :  Doptor is Opensource CMS.
===================================================
*/
use App;
use Eloquent;
use File;
use Input;

use Image;
use Robbo\Presenter\PresentableInterface;

use Modules\Doptor\TranslationManager\Presenters\TranslationManagerPresenter;

class TranslationLanguage extends Eloquent implements PresentableInterface {
    protected $table = 'translation_languages';

    protected $fillable = array();
    protected $guarded = array('id');

    /**
     * Create a new slide
     * @param array $attributes
     * @return void
     */
    public static function create(array $attributes = array())
    {
        App::make('Modules\\Doptor\\TranslationManager\\Validation\\LanguageValidator')->validateForCreation($attributes);

        parent::create($attributes);
    }

    /**
     * Update an existing slide
     * @param array $attributes
     * @return void
     */
    public function update(array $attributes = array(), array $options = array())
    {
        App::make('Modules\\Doptor\\TranslationManager\\Validation\\LanguageValidator')->validateForUpdate($attributes);

        parent::update($attributes);
    }

    /**
     * Initiate the presenter class
     */
    public function getPresenter()
    {
        return new TranslationManagerPresenter($this);
    }
}
