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
        list($this->link_type, $this->link, $this->layout, $this->current_theme) = current_section();

        View::share('link_type', $this->link_type);

        $website_settings = Setting::lists('value', 'name');

        View::share('website_settings', $website_settings);

        $this->user = current_user();

        View::share('current_user', $this->user);
    }

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if (!is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
