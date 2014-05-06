<?php
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
use Robbo\Presenter\PresentableInterface;

class Theme extends Eloquent implements PresentableInterface {
    protected $table = 'themes';

	protected $guarded = array('id');
    public static $rules = array();

    // Path in the public folder to upload image and its corresponding thumbnail
    protected $images_path = 'uploads/media/';
    protected $thumbs_path = 'uploads/media/thumbs/';

    /**
     * When creating a theme, run the attributes through a validator first.
     * @param array $attributes
     * @return void
     */
    public static function create(array $attributes = array())
    {
        // App::make('Components\\ThemeManager\\Validation\\ThemeValidator')->validateForCreation($attributes);

        $attributes['created_by'] = current_user()->id;

        return parent::create($attributes);
    }

    /**
     * When updating a theme, run the attributes through a validator first.
     * @param array $attributes
     * @return void
     */
    public function update(array $attributes = array())
    {
        // App::make('Components\\ThemeManager\\Validation\\ThemeValidator')->validateForUpdate($attributes);

        $attributes['updated_by'] = current_user()->id;

        return parent::update($attributes);
    }

    /**
     * Initiate the presenter class
     */
    public function getPresenter()
    {
        return new ThemePresenter($this);
    }

    /**
     * Get all the targets available for a theme
     * @return array
     */
    public static function all_targets()
    {
        return array(
                'public'  => 'Public',
                'admin'   => 'Admin',
                'backend' => 'Backend'
            );
    }

    public static function themeLists($target=null)
    {
        if ($target) {
            $items = static::where('target', '=', $target)->get();

            return array_pluck($items, 'name', 'id');
        }
    }
}
