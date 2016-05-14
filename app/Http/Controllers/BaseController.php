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
class BaseController extends Controller {

    /**
     * The layout that should be used for responses.
     */
    protected $layout;

    /**
     * Initializer.
     *
     * @access   public
     * @return BaseController
     */
    public function __construct()
    {
        $is_admin = Request::is('admin*');
        $is_backend = Request::is('backend*');

        /* Set middleware(s) based on route URLs */
        if ($is_admin || $is_backend) {
            $this->middleware('auth');

            if ($is_backend) {
                // Backend specific middleware
                $this->middleware('auth.backend');
            }

            $this->middleware('auth.permissions');

            if (!Request::is('*users/change-password')) {
                // No validation for stale password if password is being changed
                $this->middleware('auth.pw_6_months');
            }
        }

        list($this->link_type, $this->link, $this->layout, $this->current_theme) = current_section();

        View::share('link_type', $this->link_type);
        View::share('current_theme', $this->current_theme);

        $website_settings = Setting::lists('value', 'name')->all();

        View::share('website_settings', $website_settings);

        $locale = Setting::value('language');
        App::setLocale($locale);
        Lang::setLocale($locale);

        $this->user = current_user();

        View::share('current_user', $this->user);
        View::share('current_user_companies', current_user_companies());
    }


    /**
     * Show the user profile.
     */
    public function setContent($view, $data = [])
    {

        if ( ! is_null($this->layout))
        {
            return $this->layout->nest('child', $view, $data);
        }

        return view($view, $data);

    }

    /**
     * Set the layout used by the controller.
     *
     * @param $name
     * @return void
     */
    protected function setLayout($name)
    {
        $this->layout = $name;
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if ( ! is_null($this->layout))
        {
            $this->layout = view($this->layout);
        }
    }


    public function callAction($method, $parameters)
    {
        $this->setupLayout();

        $response = call_user_func_array(array($this, $method), $parameters);

        if (is_null($response) && ! is_null($this->layout))
        {
            $response = $this->layout;
        }

        return $response;
    }

}
