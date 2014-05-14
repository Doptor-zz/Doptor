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
Route::get('/', function() {
    if (!Schema::hasTable('settings') || Config::get('database.default') == 'sqlite') {
        // If not installed, redirect to install page
        return Redirect::to('install');
    } else {
        return Redirect::action('HomeController@index');
    }
});

Route::get('home', 'HomeController@index');
Route::get('wrapper/{id}', 'HomeController@wrapper');
Route::get('contact', 'HomeController@getContact');
Route::post('contact', 'HomeController@postContact');

Route::group(array('prefix' => 'install', 'before' => 'isInstalled'), function() {
    Route::get('{step?}', 'InstallController@index');
    Route::post('configure/{step?}', 'InstallController@configure');
    Route::post('delete_files', 'InstallController@delete_files');
});

Route::get('login', 'AuthController@getLogin');
Route::get('login/{target}', 'AuthController@getLogin');
Route::post('login', 'AuthController@postLogin');
Route::post('login/{target}', 'AuthController@postLogin');
Route::get('logout', 'AuthController@getLogout');
Route::post('forgot_password', 'AuthController@postForgotPassword');
Route::get('reset_password/{id}/{token}/{target?}', 'AuthController@getResetPassword');
Route::post('reset_password', 'AuthController@postResetPassword');

Route::get('admin/profile', 'Backend\ProfileController@showProfile');
Route::get('admin/profile/edit', 'Backend\ProfileController@editProfile');

Route::get('backend/profile', 'Backend\ProfileController@showProfile');
Route::get('backend/profile/edit', 'Backend\ProfileController@editProfile');

/*
  |--------------------------------------------------------------------------
  | Backend Routes
  |--------------------------------------------------------------------------
 */

// Authentication is required to view any backend resources
Route::when('backend*', array('auth', 'auth.backend', 'auth.permissions'));

Route::get('pages/category/{alias}', 'Components\Posts\Controllers\PostsController@category');
Route::resource('pages', 'Components\Posts\Controllers\PostsController');

Route::get('posts/category/{alias}', 'Components\Posts\Controllers\PostsController@category');
Route::resource('posts', 'Components\Posts\Controllers\PostsController');

Route::group(array('prefix' => 'backend'), function() {

    Route::any('/', 'Backend\HomeController@getIndex');
    Route::get('config', 'Backend\HomeController@getConfig');
    Route::post('config', array('uses' => 'Backend\HomeController@postConfig', 'as' => 'config'));

    Route::resource('menu-manager', 'Backend\MenuManagerController');
    Route::resource('menu-categories', 'Backend\MenuCategoriesController');

    Route::resource('form-builder', 'Backend\FormBuilderController');
    Route::resource('form-categories', 'Backend\FormCategoriesController');

    Route::post('users/{id}/activate', array('as' => 'backend.users.activate', 'uses' => 'Backend\UserController@activate'));
    Route::post('users/{id}/deactivate', array('as' => 'backend.users.deactivate', 'uses' => 'Backend\UserController@deactivate'));

    Route::get('synchronize', 'Backend\SynchronizeController@getIndex');
    Route::get('synchronize/localToWeb', 'Backend\SynchronizeController@getLocalToWeb');
    Route::post('synchronize/localToWeb', 'Backend\SynchronizeController@postLocalToWeb');
    Route::get('synchronize/webToLocal', 'Backend\SynchronizeController@getWebToLocal');
    Route::post('synchronize/webToLocal', 'Backend\SynchronizeController@postWebToLocal');
    Route::post('synchronize/syncFromFile', 'Backend\SynchronizeController@postSyncFromFile');
    // Route::get('synchronize/syncToFile', 'Backend\SynchronizeController@postSyncToFile');
    Route::post('synchronize/syncToFile', 'Backend\SynchronizeController@postSyncToFile');

    Route::resource('users', 'Backend\UserController');
    Route::resource('user-groups', 'Backend\UserGroupsController');

    Route::get('modules', array('as' => 'backend.modules.index', 'uses' => 'Backend\ModulesController@getIndex'));
    Route::get('modules/install', array('as' => 'backend.modules.create', 'uses' => 'Backend\ModulesController@getInstall'));
    Route::post('modules/install', array('as' => 'backend.modules.store', 'uses' => 'Backend\ModulesController@postInstall'));
    Route::delete('modules/delete/{id}', array('uses' => 'Backend\ModulesController@getDelete', 'as' => 'backend.modules.destroy'));

    Route::get('module-builder/download/{id}', 'Backend\ModuleBuilderController@download');
    Route::resource('module-builder', 'Backend\ModuleBuilderController');

    Route::resource('slideshow', 'Backend\SlideshowController');

    // For pages and posts
    Route::resource('pages', 'Components\Posts\Controllers\Backend\PostsController');
    Route::resource('page-categories', 'Components\Posts\Controllers\Backend\PostCategoriesController');

    Route::resource('posts', 'Components\Posts\Controllers\Backend\PostsController');
    Route::resource('post-categories', 'Components\Posts\Controllers\Backend\PostCategoriesController');

    Route::any('media-manager/create_folder', 'Components\MediaManager\Controllers\Backend\MediaManagerController@create_folder');
    Route::any('media-manager/folder_contents', 'Components\MediaManager\Controllers\Backend\MediaManagerController@folder_contents');
    Route::resource('media-manager', 'Components\MediaManager\Controllers\Backend\MediaManagerController');

    Route::post('theme-manager/apply/{id}', array('uses' => 'Components\ThemeManager\Controllers\Backend\ThemeManagerController@apply', 'as' => 'backend.theme-manager.apply'));
    Route::resource('theme-manager', 'Components\ThemeManager\Controllers\Backend\ThemeManagerController');

    Route::get('report-builder', 'Backend\ReportBuilderController@index');
    Route::post('report-builder', array('uses' => 'Backend\ReportBuilderController@postIndex', 'as' => 'backend.report-builder.store'));
    Route::get('report-builder/module-fields/{id}', 'Backend\ReportBuilderController@getModuleFields');
});

/*
  |--------------------------------------------------------------------------
  | Admin Routes
  |--------------------------------------------------------------------------
 */
// Authentication is required to view any admin resources
Route::when('admin*', array('auth', 'auth.permissions'));

Route::group(array('prefix' => 'admin'), function() {

    Route::any('/', 'Backend\HomeController@getIndex');
    Route::get('config', 'Backend\HomeController@getConfig');
    Route::post('config', array('uses' => 'Backend\HomeController@postConfig', 'as' => 'config'));

    Route::resource('menu-manager', 'Backend\MenuManagerController');
    Route::resource('menu-categories', 'Backend\MenuCategoriesController');

    Route::resource('form-builder', 'Backend\FormBuilderController');
    Route::resource('form-categories', 'Backend\FormCategoriesController');

    Route::post('users/{id}/activate', array('as' => 'backend.users.activate', 'uses' => 'Backend\UserController@activate'));
    Route::post('users/{id}/deactivate', array('as' => 'backend.users.deactivate', 'uses' => 'Backend\UserController@deactivate'));

    Route::get('synchronize', 'Backend\SynchronizeController@getIndex');
    Route::get('synchronize/localToWeb', 'Backend\SynchronizeController@getLocalToWeb');
    Route::post('synchronize/localToWeb', 'Backend\SynchronizeController@postLocalToWeb');
    Route::get('synchronize/webToLocal', 'Backend\SynchronizeController@getWebToLocal');
    Route::post('synchronize/webToLocal', 'Backend\SynchronizeController@postWebToLocal');
    Route::post('synchronize/syncFromFile', 'Backend\SynchronizeController@postSyncFromFile');
    // Route::get('synchronize/syncToFile', 'Backend\SynchronizeController@postSyncToFile');
    Route::post('synchronize/syncToFile', 'Backend\SynchronizeController@postSyncToFile');

    Route::resource('users', 'Backend\UserController');
    Route::resource('user-groups', 'Backend\UserGroupsController');

    Route::get('modules', array('as' => 'admin.modules.index', 'uses' => 'Backend\ModulesController@getIndex'));
    Route::get('modules/install', array('as' => 'admin.modules.create', 'uses' => 'Backend\ModulesController@getInstall'));
    Route::post('modules/install', array('as' => 'admin.modules.store', 'uses' => 'Backend\ModulesController@postInstall'));
    Route::delete('modules/delete/{id}', array('uses' => 'Backend\ModulesController@getDelete', 'as' => 'admin.modules.destroy'));

    Route::get('module-builder/download/{id}', 'Backend\ModuleBuilderController@download');
    Route::resource('module-builder', 'Backend\ModuleBuilderController');

    Route::resource('slideshow', 'Backend\SlideshowController');

    // For pages and posts
    Route::resource('pages', 'Components\Posts\Controllers\Backend\PostsController');
    Route::resource('page-categories', 'Components\Posts\Controllers\Backend\PostCategoriesController');

    Route::resource('posts', 'Components\Posts\Controllers\Backend\PostsController');
    Route::resource('post-categories', 'Components\Posts\Controllers\Backend\PostCategoriesController');

    Route::any('media-manager/create_folder', 'Components\MediaManager\Controllers\Backend\MediaManagerController@create_folder');
    Route::any('media-manager/folder_contents', 'Components\MediaManager\Controllers\Backend\MediaManagerController@folder_contents');
    Route::resource('media-manager', 'Components\MediaManager\Controllers\Backend\MediaManagerController');

    Route::post('theme-manager/apply/{id}', array('uses' => 'Components\ThemeManager\Controllers\Backend\ThemeManagerController@apply', 'as' => 'admin.theme-manager.apply'));
    Route::resource('theme-manager', 'Components\ThemeManager\Controllers\Backend\ThemeManagerController');
});

// Custom error handling for http codes
App::error(function($exception, $code) {
    list($link_type, $link, $layout) = current_section();
    $current_user = current_user();

    if ($exception instanceof Illuminate\Database\Eloquent\ModelNotFoundException) {
        return Response::view($link_type . '.default.404', array('title' => 'Page Not Found', 'current_user' => $current_user), 404);
    }

    switch ($code) {
        case 401:
            return Response::view($link_type . '.default.401', array('title' => 'Unauthorized access', 'current_user' => $current_user), 401);
            break;

        case 404:
            return Response::view($link_type . '.default.404', array('title' => 'Page Not Found', 'current_user' => $current_user), 404);
            break;

        case 503:
            return Response::view('503', array('title' => 'Site Offline', 'link_type' => $link_type), 503);
            break;

        // default:
        //     return Response::view($link_type . '.default.500', array('title'=>'Error'), $code);
        //     break;
    }
});
