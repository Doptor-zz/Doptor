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

class Menu extends Eloquent implements PresentableInterface {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'menus';

    public static $accessible = array('order', 'title', 'link', 'parent', 'category');

    // Path in the public folder to upload menu icon
    protected $images_path = 'uploads/menus/';

	protected $guarded = array('access_groups');

	public static $rules = array(
            'title'          => 'alpha_spaces|required',
            'alias'          => 'required|alpha_dash|unique:menus,alias',
            'parent'         => 'required|integer',
            'link'           => 'required',
            'order'          => 'integer',
            'category'       => 'required|not_in:0',
            'wrapper_width'  => 'integer',
            'wrapper_height' => 'integer'
        );

    /**
     * Relation with the menu categories table
     * A menu can have only one menu category
     */
    public function cat()
    {
         return $this->belongsTo('MenuCategory', 'category', 'id');
    }

    /**
     * Relation with groups table
     * A menu can be assigned to different user groups
     */
    public function groups()
    {
        return $this->belongsToMany('Group');
    }

    public static function validate($input, $id=false)
    {
        if ($id) {
            static::$rules['alias'] .= ','.$id;
        }
        return Validator::make($input, static::$rules);
    }

    /**
     * Get all the targets available for a menu
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
     * Get all the published menus that are within the publish date range
     * @return query
     */
    public function scopePublished($query)
    {
        return $query->where('status', '=', 'published')
                        ->where(function($query) {
                            $query->where('publish_start', '<', Carbon::now())
                                    ->orWhere('publish_start', '=', '0000-00-00 00:00:00')
                                    ->orWhereNull('publish_start');
                        })
                        ->where(function($query) {
                            $query->where('publish_end', '>', Carbon::now())
                                    ->orWhere('publish_end', '=', '0000-00-00 00:00:00')
                                    ->orWhereNull('publish_end');
                        });
    }

    /**
     * Get the icon with its directory location
     * @return string
     */
    public function getIconAttribute()
    {
        if ($this->attributes['icon']) {
            return $this->images_path . $this->attributes['icon'];
        }
    }

    /**
     * Upload the menu icon while creating/updating records
     * @param File Object $file
     */
    public function setIconAttribute($file)
    {
        // Only if a file is selected
        if ($file) {
            File::exists(public_path() . '/uploads/') || File::makeDirectory(public_path() . '/uploads/');
            File::exists(public_path() . '/' . $this->images_path) || File::makeDirectory(public_path() . '/' . $this->images_path);

            $file_name = $file->getClientOriginalName();
            $image = Image::make($file->getRealPath());

            if (isset($this->attributes['icon'])) {
                // Delete old image
                $old_image = $this->getIconAttribute();
                File::exists($old_image) && File::delete($old_image);
            }

            $image->resize(32, null, true)
                    ->crop(32, 32)
                    ->save($this->images_path . $file_name);

            $this->attributes['icon'] = $file_name;
        }
    }

    public function setSameWindowAttribute($value)
    {
        if ($value == 'same') {
            $this->attributes['same_window'] = true;
        } else {
            $this->attributes['same_window'] = false;
        }
    }

    public function setShowImageAttribute($value)
    {
        if ($value == 1) {
            $this->attributes['show_image'] = true;
        } else {
            $this->attributes['show_image'] = false;
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

    /**
     * Get the link associated with the menu
     */
    public function link()
    {
        if ($this->link == 'manual') {
            if ($this->is_wrapper) {
                // dd('wrapper/' . $this->id);
                return 'wrapper/' . $this->id;
            } else {
                return $this->link_manual;
            }
        } else {
            list($link_type, $link, $layout) = current_section();

            $this->link = str_replace('link_type', $link_type, $this->link);
            return $this->link;
        }
    }

    /**
     * Get the preety name of the link
     * @return string
     */
    public function link_name()
    {
        if ($this->link == 'manual') {
            return $this->link_manual;
        } else {
            switch ($this->link) {
                case '/':
                    $link = 'Home';
                    break;

                case 'posts':
                    $link = 'Posts';
                    break;

                default:
                    $link = str_replace('link_type/', '', $this->link);
                    break;
            }
            return $link;
        }
    }

    /**
     * Get all the statuses available for a menu
     * @return array
     */
    public static function all_status()
    {
        return array(
                'published'   => 'Publish',
                'unpublished' => 'Unpublish',
                'draft'       => 'Draft'
            );
    }

    public static function menu_name($id)
    {
        if ($id == 0) {
            return '-- None --';
        } else {
            $menu = Menu::find($id);
            if ($menu) {
                return $menu->title;
            } else {
                return '-- None --';
            }
        }
    }

    /**
     * The list that is displayed while selecting item for menu
     * @return array
     */
    public static function menu_lists()
    {
        $modules = array();

        foreach (Module::all(array('name')) as $module) {
            $modules['link_type/modules/' . Str::slug($module->name, '_')] = $module->name;
        }

        $pages = array();

        foreach (Post::type('page')->get(array('title', 'permalink')) as $page) {
            $pages['pages/' . $page->permalink] = $page->title;
        }

        return array(
                '/'       => 'Home',
                'Pages'   => $pages,
                'posts'   => 'Posts',
                'Modules' => $modules,
                'manual'  => 'External link'
            );
    }

    public static function menu_entries($id=0)
    {
        $all_menus = array(0=>'None');
        $categories = MenuCategory::with('menus')->get();

        foreach ($categories as $category) {
            $menus = array();
            $menu_entries = Menu::where('category', '=', $category->id)
                                    // ->where('parent', '=', 0)
                                    ->get();

            foreach ($menu_entries as $menu) {
                if ($menu->id == $id) continue;
                $menus[$menu->id] = $menu->title;
            }

            $all_menus[$category->name] = $menus;
        }

        return $all_menus;
    }

    /**
     * Get all the groups that a menu lies in
     * @return string
     */
    public function selected_groups($field='id')
    {
        $ret = array();
        foreach ($this->groups as $group) {
            $ret[] = $group->{$field};
        }
        return $ret;
    }

    /**
     * Initiate the presenter class
     */
    public function getPresenter()
    {
        return new MenuPresenter($this);
    }
}
