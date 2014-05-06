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
/**
 * Get the value of the environment variable
 * @param  string $key   name of the environment variable
 * @param  string $value default value
 * @return string
 */
function get_env($key, $value='')
{
    if (!empty($_ENV[$key])) {
        return $_ENV[$key];
    } else {
        return $value;
    }
}

/**
 * Get the value of the setting
 * @param  string $key   name of the setting
 * @param  string $value default value
 * @return string
 */
function get_setting($key, $value='')
{
    if(php_sapi_name() == 'cli' && empty($_SERVER['REMOTE_ADDR'])) {
        return '';
    }
    if (Schema::hasTable('settings')) {
        $value = Setting::value($key);
        if ($value == 'true') {
            return true;
        } elseif ($value == 'false') {
            return false;
        } else {
            return $value;
        }
    } else {
        return $value;
    }
}

function temp_path()
{
    return storage_path() . '/temp';
}

function backup_path()
{
    return storage_path() . '/backup';
}

function restore_path()
{
    return storage_path() . '/restore';
}

/**
 * Get the information whether the current section is backend, admin or public
 * @return array
 */
function current_section()
{
    if (Schema::hasTable('themes') && Theme::all()->count() == 0) {
        // If for some reason, there are no themes in theme table, seed with the default data
        Artisan::call('db:seed', array('ThemesTableSeeder'));
    }
    if (Request::is('backend*')) {
        $link_type = 'backend';
        $link = 'backend/';
        $theme = (Schema::hasTable('themes')) ? Theme::find(Setting::value('backend_theme', 1))->directory : 'default';
        $layout = "backend.{$theme}._layouts._layout";
    } elseif (Request::is('admin*')) {
        $link_type = 'admin';
        $link = 'admin/';
        $theme = (Schema::hasTable('themes')) ? Theme::find(Setting::value('admin_theme', 1))->directory : 'default';
        $layout = "admin.{$theme}._layouts._layout";
    } else {
        $link_type = 'public';
        $link = '';
        $theme = (Schema::hasTable('themes')) ? Theme::find(Setting::value('public_theme', 1))->directory : 'default';
        $layout = "public.{$theme}._layouts._layout";
    }
    return array($link_type, $link, $layout, $theme);
}

/**
 * Get the current logged in user
 * @return user
 */
function current_user()
{
    try {
        // Get the current active/logged in user
        $user = \Sentry::getUser();
    } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
        // User wasn't found, should only happen if the user was deleted
        // when they were already logged in or had a "remember me" cookie set
        // and they were deleted.
        Sentry::logout();
        return Redirect::to('/');
    }
    return $user;
}

function can_access_menu($user, $menus=array())
{
    $menus = (array)$menus;

    // Get the user permissions
    $permissions = $user->getMergedPermissions();

    $access_areas = array();
    foreach ($menus as $menu) {
        foreach ($permissions as $permission=>$value) {
            if (str_contains("{$permission}.", $menu)) {
                $access_areas[] = $permission;
            }
        }
    }

    if ($user->hasAnyAccess($access_areas)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Return an array of timezones
 *
 * @return array
 */
function timezoneList()
{
    $timezoneIdentifiers = DateTimeZone::listIdentifiers();
    $utcTime = new DateTime('now', new DateTimeZone('UTC'));

    $tempTimezones = array();
    foreach ($timezoneIdentifiers as $timezoneIdentifier) {
        $currentTimezone = new DateTimeZone($timezoneIdentifier);

        $tempTimezones[] = array(
            'offset' => (int)$currentTimezone->getOffset($utcTime),
            'identifier' => $timezoneIdentifier
        );
    }

    // Sort the array by offset,identifier ascending
    usort($tempTimezones, function($a, $b) {
        return ($a['offset'] == $b['offset'])
            ? strcmp($a['identifier'], $b['identifier'])
            : $a['offset'] - $b['offset'];
    });

    $timezoneList = array();
    foreach ($tempTimezones as $tz) {
        $sign = ($tz['offset'] > 0) ? '+' : '-';
        $offset = gmdate('H:i', abs($tz['offset']));
        $timezoneList[$tz['identifier']] = '(UTC ' . $sign . $offset . ') ' .
            $tz['identifier'];
    }

    return $timezoneList;
}
