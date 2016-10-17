<?php
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
use Robbo\Presenter\PresentableInterface;

class ThemeSetting extends Eloquent implements PresentableInterface {
    protected $table = 'theme_settings';

    protected $guarded = ['id'];
    protected $fillable = ['theme_id', 'name', 'description', 'value'];
    public static $rules = [];

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
        $attributes['created_by'] = current_user()->id;

        return parent::create($attributes);
    }

    /**
     * When updating a theme, run the attributes through a validator first.
     * @param array $attributes
     * @return void
     */
    public function update(array $attributes = array(), array $options = array())
    {
        $attributes['updated_by'] = current_user()->id;

        return parent::update($attributes);
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = (is_array($value)) ? json_encode($value) : $value;
    }

    public function getValueAttribute($value)
    {
        if (is_numeric($value) || !$this->isJson($value)) {
            return $value;
        } else {
            return json_decode($value);
        }
    }

    public function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * Get the value of setting for the specified name
     * @param  string $name
     * @param  string $default
     * @return string
     */
    public static function getSetting($name, $default, $theme_id)
    {
        $subname = null;

        if (str_contains($name, '[')) {
            $matches = [];
            preg_match('/(?P<name>.*?)(\[(?P<subname>.*?)\])/', $name, $matches);
            $name = $matches['name'];
            $subname = $matches['subname'];
        }

        $setting = static::whereName($name)->whereThemeId($theme_id)->first();

        if (!$setting) {
            return $default;
        }

        if ($subname) {
            $ret = isset($setting->value->{$subname}) ? $setting->value->{$subname} : '';
        } else {
            $ret = $setting->value;
        }

        return $ret;
    }

    public static function saveSetting($name, $value, $public_theme_id)
    {
        $existing_setting = static::where('name', $name)
                                    ->where('theme_id', $public_theme_id)
                                    ->first();

        if (empty($existing_setting)) {
            static::create([
                    'theme_id' => $public_theme_id,
                    'name'     => $name,
                    'value'    => $value
                ]);
        } else {
            $existing_setting->update(['value' => $value]);
        }
    }

    /**
     * Initiate the presenter class
     */
    public function getPresenter()
    {
        return new ThemePresenter($this);
    }
}
