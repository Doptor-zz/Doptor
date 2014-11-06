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
use Carbon\Carbon;

class Post extends Eloquent implements PresentableInterface {
    protected $table = 'posts';

    protected $fillable = array('title', 'permalink', 'image', 'content', 'status', 'target', 'featured', 'publish_start', 'publish_end', 'meta_title', 'meta_description', 'meta_keywords', 'type', 'hits', 'extras', 'created_by', 'updated_by');
    protected $guarded = array('id', 'categories');

    // Path in the public folder to upload image and its corresponding thumbnail
    protected $images_path = 'uploads/posts/';
    protected $thumbs_path = 'uploads/posts/thumbs/';

    /**
     * Relation with the categories table
     * A post can have many categories
     */
    public function categories()
    {
        return $this->belongsToMany('Category');
    }

    /**
     * When creating a post, run the attributes through a validator first.
     * @param array $attributes
     * @return void
     */
    public static function create(array $attributes = array())
    {
        App::make('Components\\Posts\\Validation\\PostValidator')->validateForCreation($attributes);

        $extras = array();
        $extras['contact_page'] = isset($attributes['contact']);
        $extras['contact_coords'] = isset($attributes['contact_coords']) ?
            $attributes['contact_coords'] : '';

        $attributes['extras'] = json_encode($extras);

        $attributes['featured'] = (isset($attributes['featured'])) ? true : false;
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
        App::make('Components\\Posts\\Validation\\PostValidator')->validateForUpdate($attributes);

        $extras = array();
        $extras['contact_page'] = isset($attributes['contact']);
        $extras['contact_coords'] = isset($attributes['contact_coords']) ?
            $attributes['contact_coords'] : '';

        $attributes['extras'] = json_encode($extras);

        $attributes['featured'] = (isset($attributes['featured'])) ? true : false;
        $attributes['updated_by'] = current_user()->id;

        return parent::update($attributes);
    }

    /**
     * Automatically set the permalink, if one is not provided
     * @param string $permalink
     */
    public function setPermalinkAttribute($permalink)
    {
        if ($permalink == '') {
            $this->attributes['permalink'] = Str::slug($this->attributes['title'], '-');

            if (Post::where('permalink', '=', $this->attributes['permalink'])->first()) {
                $this->attributes['permalink'] = Str::slug($this->attributes['title'], '-') . '-1';
            }
        } else {
            $this->attributes['permalink'] = $permalink;
        }
    }

    /**
     * Upload the image while creating/updating records
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
                File::exists(public_path() . '/' . $this->thumbs_path) || File::makeDirectory(public_path() . '/' . $this->thumbs_path);

                $file_name = $file->getClientOriginalName();
                $image = Image::make($file->getRealPath());

                if (isset($this->attributes['image'])) {
                    // Delete old image
                    $old_image = $this->getImageAttribute();
                    File::exists($old_image) && File::delete($old_image);
                }

                if (isset($this->attributes['thumb'])) {
                    // Delete old thumbnail
                    $old_thumb = $this->getThumbAttribute();
                    File::exists($old_thumb) && File::delete($old_thumb);
                }

                $image->save($this->images_path . $file_name)
                    ->fit(640, 180)
                    ->save($this->thumbs_path . $file_name);

                $file_name = $this->images_path . $file_name;

            } else {
                $image = Image::make($file);
                $file_name = $file;

                $image->fit(640, 180)
                    ->save($this->thumbs_path . basename($file_name));
            }

            $this->attributes['image'] = $file_name;
        }
    }

    /**
     * Set the start publish field
     */
    public function setPublishStartAttribute($date)
    {
        if ($date == '') {
            $this->attributes['publish_start'] = null;
        } else {
            $this->attributes['publish_start'] = $date;
        }
    }

    /**
     * Set the end publish field
     */
    public function setPublishEndAttribute($date)
    {
        if ($date == '') {
            $this->attributes['publish_end'] = null;
        } else {
            $this->attributes['publish_end'] = $date;
        }
    }

    public function setCreatedAtAttribute($created_at)
    {
        if ($created_at == '') {
            $this->attributes['created_at'] = Carbon::now();
        } else {
            $created_at = str_replace('-000', '000', $created_at);
            $this->attributes['created_at'] = Carbon::createFromFormat('Y-m-d H:i:s', $created_at);
            if ($this->attributes['created_at']->year < 2000) {
                $this->attributes['created_at'] = Carbon::now();
            }
        }
    }

    public function setUpdatedAtAttribute($updated_at)
    {
        $updated_at = str_replace('-000', '000', $updated_at);
        $updated_at = Carbon::createFromFormat('Y-m-d H:i:s', $updated_at);
        if ($updated_at->year < 2000) {
            $this->attributes['updated_at'] = Carbon::now();
        }
    }

    /**
     * Get the image with its directory location
     * @return string
     */
    public function getImageAttribute()
    {
        if ($this->attributes['image']) {
            return $this->attributes['image'];
        }
    }

    /**
     * Get the thumbnail with its directory location
     * @return string
     */
    public function getThumbAttribute()
    {
        if ($this->attributes['image']) {
            return $this->thumbs_path . basename($this->attributes['image']);
        }
    }

    /**
     * Get all the published posts that are within the publish date range
     * @return query
     */
    public function scopePublished($query)
    {
        return $query->where('status', '=', 'published')
            ->where(function ($query) {
                $query->where('publish_start', '<', Carbon::now())
                    ->orWhereNull('publish_start');
            })
            ->where(function ($query) {
                $query->where('publish_end', '>', Carbon::now())
                    ->orWhereNull('publish_end');
            });
    }

    /**
     * Get all the posts belonging to a specific type
     * @param  query $query
     * @param  string $type
     * @return query
     */
    public function scopeType($query, $type = 'post')
    {
        return $query->where('type', '=', $type);
    }

    /**
     * Get the recently created posts
     * @return query
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'DESC');
    }

    /**
     * Get all the posts that lie in the specified target
     * @param  Query $query
     * @param  string $target
     * @return Query
     */
    public function scopeTarget($query, $target = 'public')
    {
        return $query->where('target', '=', $target);
    }

    /**
     * Get all the targets available for a post
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
        return new PostPresenter($this);
    }
}
