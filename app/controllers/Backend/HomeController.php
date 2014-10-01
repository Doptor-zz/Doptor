<?php namespace Backend;
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
use Input;
use MenuPosition;
use Redirect;
use Request;
use Setting;
use View;

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
                                            ->with('menu_items', $menu_items);
        } else {
            $this->layout->content = View::make($this->link_type.'.'.$this->current_theme.'.index');
        }
    }

    /**
     * Configuration of the website
     * @return View
     */
    public function getConfig()
    {
        if (!$this->user->hasAnyAccess(array('config.create', 'config.update'))) App::abort('401');

        $this->layout->title = 'Website Configuration';
        $this->layout->content = View::make($this->link_type.'.'.$this->current_theme.'.config');
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
                            ->with('error_message', 'Current IP address cannot be disabled access');
        }

        foreach ($input as $name => $value) {
            Setting::findOrCreate($name, $value);
        }

        return Redirect::back()
                            ->with('success_message', 'The settings were updated.');
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
}
