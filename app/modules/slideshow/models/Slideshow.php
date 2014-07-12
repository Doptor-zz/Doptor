<?php namespace Modules\Slideshow\Models;
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
use File;
use Input;

use Image;
use Robbo\Presenter\PresentableInterface;

use Modules\Slideshow\Presenters\SlideshowPresenter;

class Slideshow extends Eloquent implements PresentableInterface {
    protected $table = 'slideshow';

    // Path in the public folder to upload slides
    protected $images_path = 'uploads/slideshow/';

    protected $fillable = array();
    protected $guarded = array('id');

    /**
     * Create a new slide
     * @param array $attributes
     * @return void
     */
    public static function create(array $attributes = array())
    {
        App::make('Modules\\Slideshow\\Validation\\SlideshowValidator')->validateForCreation($attributes);

        parent::create($attributes);
    }

    /**
     * Update an existing slide
     * @param array $attributes
     * @return void
     */
    public function update(array $attributes = array())
    {
        App::make('Modules\\Slideshow\\Validation\\SlideshowValidator')->validateForUpdate($attributes);

        parent::update($attributes);
    }

    /**
     * Get the slideshow image with its directory location
     * @return string
     */
    public function getImageAttribute()
    {
        $image = $this->attributes['image'];
        if ($image) {
            if (str_contains($image, '/')) {
                return $image;
            } else {
                // if the slideshow image has been uploaded
                // using old version of file upload
                return $this->images_path . $image;
            }
        }
    }

    /**
     * Upload the slideshow image while creating/updating records
     * @param File Object $file
     */
    public function setImageAttribute($file)
    {
        // Only if a file is selected
        if ($file) {
            if (Input::hasFile('image')) {
                // If an actual file is selected
                File::exists(public_path() . '/uploads/') || File::makeDirectory(public_path() . '/uploads/');
                File::exists(public_path() . '/' . $this->images_path) || File::makeDirectory(public_path() . '/' . $this->images_path);

                $file_name = $file->getClientOriginalName();
                $image = Image::make($file->getRealPath());

                if (isset($this->attributes['image'])) {
                    // Delete old image
                    $old_image = $this->getIconAttribute();
                    File::exists($old_image) && File::delete($old_image);
                }

                $image->save($this->images_path . $file_name);

                $file_name = $this->images_path . $file_name;
            } else {

                $file_name = $file;

            }

            $this->attributes['image'] = $file_name;
        }
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
        return new SlideshowPresenter($this);
    }
}
