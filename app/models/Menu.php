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

    public static $accessible = array('order', 'title', 'link', 'parent', 'category', 'position');

    // Path in the public folder to upload menu icon
    protected $images_path = 'uploads/menus/';

	protected $guarded = array('access_groups');

	public static $rules = array(
            'title'          => 'alpha_spaces|required',
            'alias'          => 'required|alpha_dash|unique:menus,alias',
            'parent'         => 'required|integer',
            'link'           => 'required',
            'order'          => 'integer',
            'position'       => 'required|not_in:0',
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
     * Relation with the menu positions table
     * A menu can have only one menu position
     */
    public function pos()
    {
         return $this->belongsTo('MenuPosition', 'position', 'id');
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
            return $this->attributes['icon'];
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
            if (Input::hasFile('icon')) {
                File::exists(public_path() . '/uploads/') || File::makeDirectory(public_path() . '/uploads/');
                File::exists(public_path() . '/' . $this->images_path) || File::makeDirectory(public_path() . '/' . $this->images_path);

                $file_name = $file->getClientOriginalName();
                $image = Image::make($file->getRealPath());

                if (isset($this->attributes['icon'])) {
                    // Delete old image
                    $old_image = $this->getIconAttribute();
                    File::exists($old_image) && File::delete($old_image);
                }

                $image->fit(32, 32)
                        ->save($this->images_path . $file_name);

                $file_name = $this->images_path . $file_name;
            } else {
                $file_name = $file;
            }

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

            $this->link = str_replace('link_type/', $link, $this->link);
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
        foreach (Module::all(array('name', 'links')) as $module) {
            if ($module->links != '') {
                $links = json_decode($module->links);
                foreach ($links as $link) {
                    $modules['link_type/modules/' . $link->alias] = $link->name;
                }
            } else {
                $modules['link_type/modules/' . Str::slug($module->name, '_')] = $module->name;
            }
        }

        $pages = array();
        foreach (Post::type('page')->get(array('title', 'permalink')) as $page) {
            $pages['pages/' . $page->permalink] = $page->title;
        }

        $post_categories = array();
        foreach (Category::type('post')->get(array('name', 'alias')) as $page_category) {
            $post_categories['posts/category/' . $page_category->alias] = $page_category->name;
        }

        $contacts = array();
        foreach (Components\ContactManager\Models\ContactDetail::get(array('name', 'alias')) as $contact) {
            $contacts['contact/show/' . $contact->alias] = $contact->name;
        }

        $contact_categories = array();
        foreach (Components\ContactManager\Models\ContactCategory::get(array('name', 'alias')) as $contact_cat) {
            $contact_categories['contact/' . $contact_cat->alias] = $contact_cat->name;
        }

        $forms = array();
        foreach (BuiltForm::get(array('name', 'id')) as $contact_cat) {
            $forms['link_type/form/' . $contact_cat->id] = $contact_cat->name;
        }

        $report_generators = array();
        foreach (Components\ReportGenerator\Models\ReportGenerator::get(array('name', 'id')) as $report_generator) {
            $report_generators['admin/report-generators/generate/' . $report_generator->id] = $report_generator->name;
        }

        return array(
                '/'                  => 'Home',
                'Pages'              => $pages,
                'posts'              => 'Posts',
                'Post Categories'    => $post_categories,
                'Modules'            => $modules,
                'Contact Categories' => $contact_categories,
                'Contacts'           => $contacts,
                'Forms'              => $forms,
                'Report Generators'  => $report_generators,
                'manual'             => 'External link'
            );
    }

    public static function menu_entries($id=0)
    {
        $all_menus = array(0=>'None');
        $menu_entries = Menu::with('cat')->get();

        foreach ($menu_entries as $menu_entry) {
            if ($menu_entry->id == $id) continue;
            $menu = array(
                    $menu_entry->id => $menu_entry->title
                );

            if ($menu_entry->cat) {
                $cat_name = $menu_entry->cat->name;
                $all_menus[$cat_name][$menu_entry->id] = $menu_entry->title;
            } else {
                $all_menus[$menu_entry->id] = $menu_entry->title;
            }
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
