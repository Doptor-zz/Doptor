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

App::before(function($request)
{
    // Check whether the specific section is offline or not before any request
    list($link_type, $link, $layout) = current_section();
    if (Schema::hasTable('settings') && Setting::isOffline($link_type)) {
        App::abort(503);
    }

    // Get the language based on what is saved in the session
    $language = Session::get('language', 'en');
    App::setLocale($language);
});


App::after(function($request, $response)
{
    //
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

// Check whether or not the app is installed
Route::filter('isInstalled', function() {
    if (Schema::hasTable('settings')) {
        return Redirect::to('/');
    }
});

Route::filter('auth', function()
{
    if (!Sentry::check()) {
        return Redirect::guest('login/' . Request::segment(1));
    }
});

Route::filter('auth.pw_6_months', function()
{
    // Check if the users password was changed within last 6 months or not
    // If not ask him to change his password, before he can log in
    $last_pw_changed = new Carbon\Carbon(current_user()->last_pw_changed);

    if (Carbon\Carbon::now()->diffInDays($last_pw_changed) > 180) {
        return Redirect::to(Request::segment(1) . '/users/change-password')
                        ->with('error_message', 'It has been more than 6 months since you last changed your password. You need to change it before you can log in.');
    }
});

Route::filter('auth.backend', function()
{
    // Check whether the user has backend access or not
    if (!current_user()->hasAccess('backend')) {
        return Redirect::to('admin');
    }
});

Route::filter('auth.permissions', function()
{
    // Authorize all admin/backend routes/paths
    $route = Route::currentRouteName() ?: Route::current()->getPath();
    $route = preg_replace('/(admin(\.|\/)?|backend(\.|\/)?)?/', '', $route);
    $route = str_replace('.store', '.create', $route);
    $route = str_replace('.update', '.edit', $route);

    if(!current_user()->hasAccess($route)) {
        return App::abort(401);
    }
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
    if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function($route, $request)
{
    if (strtoupper($request->getMethod()) === 'GET') {
        return; // get requests are not CSRF protected
    }

    $token = $request->header('X-CSRF-Token') ?: Input::get('_token');

    if (Session::token() != $token) {
        throw new Illuminate\Session\TokenMismatchException;
    }
});
