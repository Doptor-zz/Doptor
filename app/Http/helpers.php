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

/**
 * Get the theme setting for the key
 * @param  string $key
 * @return string
 */
function theme_setting($key, $default='')
{
    $public_theme_id = Setting::value("public_theme", 1);

    return ThemeSetting::getSetting($key, $default, $public_theme_id);
}

/**
 * Get the temporary directory
 * @return string
 */
function temp_path()
{
    return storage_path() . '/temp';
}

/**
 * Get the stored backups directory
 * @return string
 */
function stored_backups_path()
{
    return storage_path() . '/stored_backups';
}

/**
 * Get the backup directory
 * @return string
 */
function backup_path()
{
    return storage_path() . '/backup';
}

/**
 * Get the restore directory
 * @return string
 */
function restore_path()
{
    return storage_path() . '/restore';
}

/**
 * Reference the theme style file
 * @param  string $file
 * @param  array  $attrs
 * @return string
 */
function theme_css($file='', $attrs=[])
{
    $current_theme = current_theme('public');

    return HTML::style("assets/public/{$current_theme}/{$file}", $attrs);
}

/**
 * Reference the theme scripts file
 * @param  string $file
 * @param  array  $attrs
 * @return string
 */
function theme_js($file='', $attrs=[])
{
    $current_theme = current_theme('public');

    return HTML::script("assets/public/{$current_theme}/{$file}", $attrs);
}

/**
 * Get the assets URL for the active public theme
 * @param  string $file URL for a specific asset file
 * @return string       Full assets URL
 */
function assets_url($file='')
{
    $current_theme = current_theme('public');

    return url("public/assets/public/{$current_theme}/{$file}");
}

/**
 * Get the current theme
 * @param  string $target
 * @return string
 */
function current_theme($target='public')
{
    return (Schema::hasTable('themes')) ? Theme::find(Setting::value("{$target}_theme", 1))->directory : 'default';
}

/**
 * Does the current public theme has theme settings or not
 * @return boolean
 */
function has_theme_settings()
{
    $public_theme_id = Setting::value('public_theme');

    $public_theme = Theme::findOrFail($public_theme_id);

    return $public_theme->has_settings;
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
        $theme = current_theme('backend');
        $layout = "backend.{$theme}._layouts._layout";
    } elseif (Request::is('admin*') || Request::is('login/admin*')) {
        $link_type = 'admin';
        $link = 'admin/';
        $theme = current_theme('admin');
        $layout = "admin.{$theme}._layouts._layout";
    } else {
        $link_type = 'public';
        $link = '';
        $theme = current_theme('public');
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

/**
 * Get the companies that the user belongs to
 * @return $companies
 */
function current_user_companies()
{
    $companies = [];
    if (current_user()) {
        $company_ids = json_decode(current_user()->company_id);
        if ($company_ids) {
            return array_map('intval', $company_ids);
        }
    }
    return $companies;
}

/**
 * Check whether or not user can access the company
 * @param   $company_id
 * @return  boolean
 */
function can_user_access_company($company_id)
{
    $current_user_companies = current_user_companies();
    return (!$current_user_companies || in_array($company_id, $current_user_companies));
}

/**
 * Check whether or not user can access menu
 * @param   $user
 * @param   $menus
 * @return  boolean
 */
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
