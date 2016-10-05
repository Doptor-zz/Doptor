<?php namespace Backend;
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
use Input;
use Redirect;
use Request;
use View;

use MenuPosition;
use Setting;
use Theme;
use ThemeSetting;

use Modules\Doptor\TranslationManager\Models\TranslationLanguage;

class HomeController extends AdminController {

    /**
     * Index page of backend dashboard
     * @return View
     */
    public function getIndex()
    {
        $this->layout->title = trans('cms.home');
        if ($this->link_type == 'admin') {
            $position = MenuPosition::where('alias', '=', 'admin-main-menu')
                                    ->with('menus')
                                    ->first();

            $menu_items = $position->menus()
                            ->published()
                            ->where('parent', '=', 0)
                            ->orderBy('order', 'asc')
                            ->get();

            $this->layout->content = View::make($this->link_type.'.'.$this->current_theme.'.index')
                                            ->with('menu_items', $menu_items)
                                            ->with('title', trans('cms.home'));
        } else {
            $this->layout->content = View::make($this->link_type.'.'.$this->current_theme.'.index')
            ->with('title', trans('cms.home'));
        }
    }

    /**
     * Configuration of the website
     * @return View
     */
    public function getConfig()
    {
        $languages = TranslationLanguage::lists('name', 'code');

        if (!$this->user->hasAnyAccess(array('config.create', 'config.update'))) App::abort('401');

        $this->layout->title = 'Website Configuration';
        $this->layout->content = View::make($this->link_type.'.'.$this->current_theme.'.config')
                                        ->with('languages', $languages);
    }

    public function postConfig()
    {
        if (!$this->user->hasAnyAccess(array('config.create', 'config.update'))) App::abort('401');
        $input = Input::all();

        unset($input['_token']);

        $disabled_ips = explode(' ', $input['disabled_ips']);
        if (in_array(Request::getClientIp(), $disabled_ips)) {
            return Redirect::back()
                            ->withInput()
                            ->with('error_message', trans('error_messages.cant_disable_ip'));
        }

        foreach ($input as $name => $value) {
            Setting::findOrCreate($name, $value);
        }

        return Redirect::back()
                            ->with('success_message', trans('success_messages.config_change'));
    }

    /**
     * Display the settings for the current public theme
     * @return View
     */
    public function getThemeConfig()
    {
        $public_theme_id = Setting::value('public_theme');

        $public_theme = Theme::findOrFail($public_theme_id);

        $theme_config_view = 'public.'.$public_theme->directory.'.theme-settings';

        if (View::exists($theme_config_view)) {
            $this->layout->title = 'Theme Settings';
            $this->layout->content = View::make($theme_config_view);
        } else {
            App::abort(404);
        }
    }

    /**
     * Save the settings for the current public theme
     * @return [type] [description]
     */
    public function postThemeConfig()
    {
        if (!$this->user->hasAnyAccess(array('config.create', 'config.update'))) App::abort('401');
        $input = Input::all();

        unset($input['_token']);

        $public_theme_id = Setting::value('public_theme');

        foreach ($input as $name => $value) {
            ThemeSetting::saveSetting($name, $value, $public_theme_id);
        }

        return Redirect::back()
                            ->with('success_message', trans('success_messages.config_change'));
    }

    /**
     * Change the CMS language
     * @param   $lang
     * @return
     */
    public function getChangeLang($lang)
    {
        \Session::put('language', $lang);

        return Redirect::to($this->link_type)
                            ->with('success_message', 'The language was changed.');
    }

    /**
     * Get the language file for the datatable
     * @return [type] [description]
     */
    public function getDatatableLangfile()
    {
        $translation= \Lang::get('datatable');

        return json_encode($translation);
    }
}
