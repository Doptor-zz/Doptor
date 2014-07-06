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

class MediaEntry extends Eloquent implements PresentableInterface {
    protected $table = 'media_entries';

	protected $guarded = array('id');
    public static $rules = array();

    // Path in the public folder to upload image and its corresponding thumbnail
    public $images_path = 'uploads/media/';
    public $thumbs_path = 'uploads/media/thumbs/';

    /**
     * When creating a post, run the attributes through a validator first.
     * @param array $attributes
     * @return void
     */
    public static function create(array $attributes = array())
    {
        App::make('Components\\MediaManager\\Validation\\MediaEntryValidator')->validateForCreation($attributes);

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
        App::make('Components\\MediaManager\\Validation\\MediaEntryValidator')->validateForUpdate($attributes);

        $attributes['updated_by'] = current_user()->id;

        return parent::update($attributes);
    }

    /**
     * Upload the image while creating/updating records
     * @param File Object $file
     */
    public function setImageAttribute($file)
    {
        // Only if a file is selected
        if ($file) {
            File::exists(public_path() . '/uploads/') || File::makeDirectory(public_path() . '/uploads/');
            File::exists(public_path() . '/' . $this->images_path) || File::makeDirectory(public_path() . '/' . $this->images_path);
            File::exists(public_path() . '/' . $this->thumbs_path) || File::makeDirectory(public_path() . '/' . $this->thumbs_path);

            $file_name = $file->getClientOriginalName();

            $file_ext = File::extension($file_name);
            $only_fname = str_replace('.' . $file_ext, '', $file_name);

            $file_name = $only_fname . '_' . str_random(8) . '.' . $file_ext;

            $image = Image::make($file->getRealPath());

            if (isset($this->attributes['folder'])) {
                // $this->attributes['folder'] = Str::slug($this->attributes['folder'], '_');
                $this->images_path = $this->attributes['folder'] . '/';
                $this->thumbs_path = $this->images_path . '/thumbs/';

                File::exists(public_path() . '/' . $this->images_path) || File::makeDirectory(public_path() . '/' . $this->images_path);
                File::exists(public_path() . '/' . $this->thumbs_path) || File::makeDirectory(public_path() . '/' . $this->thumbs_path);
            }

            if (isset($this->attributes['image'])) {
                // Delete old image
                $old_image = $this->getImageAttribute();
                File::exists($old_image) && File::delete($old_image);
            }

            if (isset($this->attributes['thumbnail'])) {
                // Delete old thumbnail
                $old_thumb = $this->getThumbnailAttribute();
                File::exists($old_thumb) && File::delete($old_thumb);
            }

            $image->save($this->images_path . $file_name)
                    ->fit(150, 150)
                    ->save($this->thumbs_path . $file_name);

            $this->attributes['image'] = "{$this->attributes['folder']}/{$file_name}";
            $this->attributes['thumbnail'] = "{$this->attributes['folder']}/thumbs/{$file_name}";

            unset($this->attributes['folder']);
        }
    }

    /**
     * Get the image with its directory location
     * @return string
     */
    public function getImageAttribute()
    {
        if ($this->attributes['image']) {
            return $this->images_path . $this->attributes['image'];
        }
    }

    /**
     * Get the thumbnail with its directory location
     * @return string
     */
    public function getThumbnailAttribute()
    {
        if ($this->attributes['thumbnail']) {
            return "{$this->images_path}{$this->attributes['thumbnail']}";
        }
    }

    /**
     * Initiate the presenter class
     */
    public function getPresenter()
    {
        return new MediaEntryPresenter($this);
    }
}
