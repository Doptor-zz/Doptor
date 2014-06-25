<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
    app_path().'/models',
    app_path().'/services',
	app_path().'/services/Validation',
	app_path().'/database/seeds',

));

// Autoload all components
$components = array('posts', 'media_manager', 'theme_manager');
foreach ($components as $component) {
    ClassLoader::addDirectories(array(
        app_path().'/components/'.$component,
        app_path().'/components/'.$component.'/controllers',
        app_path().'/components/'.$component.'/controllers/backend',
        app_path().'/components/'.$component.'/database/migrations',
        app_path().'/components/'.$component.'/database/seeds',
        app_path().'/components/'.$component.'/models',
        app_path().'/components/'.$component.'/presenters',
        app_path().'/components/'.$component.'/services',
        app_path().'/components/'.$component.'/validation',
        app_path().'/components/'.$component.'/views',
    ));
}

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

Log::useFiles(storage_path().'/logs/laravel.log');

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
	Log::error($exception);
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function()
{
	return Response::make("Be right back!", 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';

/*
|--------------------------------------------------------------------------
| Require The Events File
|--------------------------------------------------------------------------
|
| we will load the events file for the application. This gives us
| a nice separate location to store our events in one place
|
*/
require app_path().'/events.php';


Validator::extend('alpha_spaces', function($attribute, $value)
{
    return preg_match('/^[\pL\s]+$/u', $value);
});
