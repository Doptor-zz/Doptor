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
 * @param  string $default default value
 * @return string
 */
function get_setting($key, $default='')
{
    if(php_sapi_name() == 'cli' && empty($_SERVER['REMOTE_ADDR'])) {
        return '';
    }
    if (Schema::hasTable('settings')) {
        $setting = Setting::whereName($key)->first();
        $value = ($setting) ? $setting->value : $default;
        if ($value == 'true') {
            return true;
        } elseif ($value == 'false') {
            return false;
        } elseif ($value == '') {
            return $default;
        } else {
            return $value;
        }
    } else {
        return $default;
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
    if (Request::is('backend*') || Request::is('login/backend*')) {
        $link_type = 'backend';
        $link = 'backend/';
        $theme = (Schema::hasTable('themes')) ? Theme::find(Setting::value('backend_theme', 1))->directory : 'default';
        $layout = "backend.{$theme}._layouts._layout";
    } elseif (Request::is('admin*') || Request::is('login/admin*')) {
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

/**
 * Compresses a folder
 * @param $source
 * @param $destination
 * @param bool $include_dir
 * @return bool
 */
function Zip($source, $destination, $include_dir = true)
{
    if (!extension_loaded('zip') || !file_exists($source)) {
        return false;
    }

    if (file_exists($destination)) {
        unlink($destination);
    }

    $zip = new \ZipArchive();
    if (!$zip->open($destination, \ZIPARCHIVE::CREATE)) {
        return false;
    }

    $source = str_replace('\\', '/', realpath($source));
    if (is_dir($source) === true) {
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($source), \RecursiveIteratorIterator::SELF_FIRST);

        if ($include_dir) {
            $arr = explode("/", $source);
            $maindir = $arr[count($arr) - 1];

            $source = "";
            for ($i = 0; $i < count($arr) - 1; $i++) {
                $source .= '/' . $arr[$i];
            }

            $source = substr($source, 1);

            $zip->addEmptyDir($maindir);
        }

        foreach ($files as $file) {
            // Ignore "." and ".." folders
            if (in_array(substr($file, strrpos($file, DIRECTORY_SEPARATOR) + 1), array('.', '..', ':')))
                continue;

            $file = realpath($file);
            // var_dump($file);
            $file = str_replace('\\', '/', $file);

            if (is_dir($file) === true) {
                $dir = str_replace($source . '/', '', $file . '/');
                $zip->addEmptyDir($dir);
            } else if (is_file($file) === true) {
                $new_file = str_replace($source . '/', '', $file);
                $zip->addFromString($new_file, file_get_contents($file));
            }
        }
    } else if (is_file($source) === true) {
        $zip->addFromString(basename($source), file_get_contents($source));
    }

    return $zip->close();
}

/**
 * Unzip a zip file
 * @param $file
 * @param $path
 * @return bool
 */
function Unzip($file, $path)
{
    $zip = new ZipArchive;
    $res = $zip->open($file);
    if ($res === true) {
        // extract it to the path we determined above
        try {
            $zip->extractTo($path);
        } catch (ErrorException $e) {
            //skip
        }
        $zip->close();

        return true;
    } else {
        return false;
    }
}
