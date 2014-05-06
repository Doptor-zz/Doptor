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
class HomeController extends AdminController {

    /**
     * Index page of backend dashboard
     * @return View
     */
    public function getIndex()
    {
        $this->layout->title = 'Home';
        if ($this->link_type == 'admin') {
            $category = \MenuCategory::where('menu_type', '=', 'admin-main-menu')
                                    ->with('menus')
                                    ->first();

            $menu_items = $category->menus()
                            ->published()
                            ->where('parent', '=', 0)
                            ->orderBy('order', 'asc')
                            ->get();

            $this->layout->content = \View::make($this->link_type.'.'.$this->current_theme.'.index')
                                            ->with('menu_items', $menu_items);
        } else {
            $this->layout->content = \View::make($this->link_type.'.'.$this->current_theme.'.index');
        }
    }

    /**
     * Configuration of the website
     * @return View
     */
    public function getConfig()
    {
        if (!$this->user->hasAnyAccess(array('config.create', 'config.update'))) \App::abort('401');

        $this->layout->title = 'Website Configuration';
        $this->layout->content = \View::make('backend.'.$this->current_theme.'.config');
    }

    public function postConfig()
    {
        if (!$this->user->hasAnyAccess(array('config.create', 'config.update'))) \App::abort('401');
        $input = \Input::all();

        unset($input['_token']);

        foreach ($input as $name => $value) {
            $config = \Setting::findOrCreate($name);
            $config->name = $name;
            $config->value = $value;
            $config->save();
        }

        return \Redirect::back()
                            ->with('success_message', 'The settings were updated.');
    }
}
