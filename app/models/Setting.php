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

class Setting extends Eloquent {

    protected $table = 'settings';

	protected $guarded = array();

	public static $protected_settings = array('email_host', 'email_port', 'email_encryption', 'email_username', 'email_password');

	public static $rules = array();

	/**
	 * Finds the entry with the specified name.
	 * If not found, creates it.
	 */
	public function scopeFindOrCreate($query, $name, $value=null)
	{
	    $obj = $query->whereName($name)->first();
	    $config = $obj ?: new static;
	    $config->name = $name;
	    if ($value) {
		    $config->value = $value;
	    }
	    $config->save();
	}

	/**
	 * Check whether the selected target is offline or not
	 */
	public static function isOffline($target)
	{
		$disabled_ips = static::whereName("disabled_ips")->first();
		if ($disabled_ips) {
			$disabled_ips = explode(' ', $disabled_ips);
			if (in_array(Request::getClientIp(), $disabled_ips)) {
				// If the current IP address is in the list of disabled
				// IP addresses, then deny access
				return true;
			}
		}

		$setting = static::whereName("{$target}_offline")->first();
		// dd($setting->value);

		if (!$setting || $setting->value == 'no') {
			return false;
		} else {
			$offline_end = static::whereName("{$target}_offline_end")->first();

			if ($offline_end->value == '' or
					Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $offline_end->value)
										> Carbon\Carbon::now(
				)) {
				return true;
			} else {
				return false;
			}
		}
	}

	/**
	 * Get the value of setting for the specified name
	 */
	public static function value($name, $default='')
	{
		// Return blank if user wants to access protected setting from public
		if (!(Request::is('backend/*') || Request::is('admin/*')) &&
			in_array($name, static::$protected_settings)) {
			return '';
		}

		$setting = static::whereName($name)->first();

		if (ends_with($name, '_offline')) {
			// Even though offline might have been selected, the time to remain offline
			// might have expired, so check to get the value
			if (static::isOffline(str_replace('_offline', '', $name))) {
				return 'yes';
			} else {
				return 'no';
			}
		}

		return ($setting) ? $setting->value : $default;
	}

	/**
	 * Set the value of setting for the specified name
	 */
	public static function setValue($name, $value)
	{
		$setting = static::findOrCreate($name)->first();

		$setting->value = $value;

		return ($setting->save()) ? true : false;
	}
}
