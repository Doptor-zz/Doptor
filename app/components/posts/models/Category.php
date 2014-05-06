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

class Category extends Eloquent implements PresentableInterface {
    protected $table = 'categories';

	protected $guarded = array('id');
    public static $rules = array();

    /**
     * Relation with posts table
     */
    public function posts()
    {
        return $this->belongsToMany('Post');
    }

    /**
     * Get all available categories
     */
    public static function all_categories($type='post')
    {
        $categories = array();

        foreach (Category::type($type)->get() as $category) {
            $categories[$category->id] = $category->name;
        }

        return $categories;
    }

    /**
     * When creating a post, run the attributes through a validator first.
     * @param array $attributes
     * @return void
     */
    public static function create(array $attributes = array())
    {
        App::make('Components\\Posts\\Validation\\CategoryValidator')->validateForCreation($attributes);
        $attributes['created_by'] = current_user()->id;

        return parent::create($attributes);
    }

    /**
     * When updating a post, run the attributes through a validator first.
     * @param array $attributes
     * @return void
     */
    public function update(array $attributes = array())
    {
        App::make('Components\\Posts\\Validation\\CategoryValidator')->validateForUpdate($attributes);
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
            $this->attributes['alias'] = Str::slug($this->attributes['name'], '-');

            if (Category::where('alias', '=', $this->attributes['alias'])->first()) {
                $this->attributes['alias'] = Str::slug($this->attributes['name'], '-') . '-1';
            }
        }
    }

    /**
     * Get all the published posts that are within the publish date range
     * @return query
     */
    public function scopePublished($query)
    {
        return $query->where('status', '=', 'published');
    }

    /**
     * Get all the posts belonging to a specific type
     * @param  query $query
     * @param  string $type
     * @return query
     */
    public function scopeType($query, $type='post')
    {
        return $query->where('type', '=', $type);
    }

    /**
     * Get all the statuses available for a post
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
        return new CategoryPresenter($this);
    }
}
