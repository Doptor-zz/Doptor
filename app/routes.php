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

// Apply CSRF protection to every routes
Route::when('*', array('csrf'));

Route::get('home', 'HomeController@index');
Route::get('wrapper/{id}', 'HomeController@wrapper');

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

Route::get('contact/{category}', 'Components\ContactManager\Controllers\PublicController@showCategory');
Route::get('contact/{category}/{contact}', 'Components\ContactManager\Controllers\PublicController@showPublic');
Route::post('contact/{contact}/send', 'Components\ContactManager\Controllers\PublicController@sendMessage');

Route::resource('form', 'FormController', array('only'=>array('store', 'show')));

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
    Route::resource('menu-positions', 'Backend\MenuPositionsController');

    Route::resource('form-builder', 'Backend\FormBuilderController');
    Route::resource('form-categories', 'Backend\FormCategoriesController');

    Route::resource('form', 'FormController', array('only'=>array('index', 'store', 'show', 'destroy')));
    Route::get('form/{id}/list', 'FormController@index');

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
    Route::get('module-builder/form-dropdowns/{id}', 'Backend\ModuleBuilderController@getFormDropdowns');
    Route::get('module-builder/form-fields/{id}', 'Backend\ModuleBuilderController@getFormFields');
    Route::resource('module-builder', 'Backend\ModuleBuilderController');

    Route::resource('slideshow', 'Modules\Slideshow\Controllers\Backend\SlideshowController');

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

    Route::get('report-builder/module-fields/{id}', 'Components\ReportBuilder\Controllers\Backend\ReportBuilderController@getModuleFields');
    Route::get('report-builder/download/{id}', 'Components\ReportBuilder\Controllers\Backend\ReportBuilderController@download');
    Route::resource('report-builder', 'Components\ReportBuilder\Controllers\Backend\ReportBuilderController');

    Route::get('report-generators/generate/{id}', 'Components\ReportGenerator\Controllers\Backend\ReportGeneratorController@getGenerate');
    Route::post('report-generators/generate/{id}', array('uses' => 'Components\ReportGenerator\Controllers\Backend\ReportGeneratorController@postGenerate', 'as' => 'backend.report-generators.generate'));
    Route::get('report-generators/install', 'Components\ReportGenerator\Controllers\Backend\ReportGeneratorController@create');
    Route::resource('report-generators', 'Components\ReportGenerator\Controllers\Backend\ReportGeneratorController');

    Route::resource('contact-categories', 'Components\ContactManager\Controllers\Backend\ContactCategoriesController');

    Route::resource('contact-manager',
                    'Components\ContactManager\Controllers\Backend\ContactController');
    Route::get('contact-manager/create/{form_id}',
                    array(
                        'uses' => 'Components\ContactManager\Controllers\Backend\ContactController@create',
                        'as' => 'backend.contact-manager.create'
                    )
                );
    Route::get('contact-manager/{id}/{form_id}',
                    array(
                        'uses' => 'Components\ContactManager\Controllers\Backend\ContactController@show',
                        'as' => 'backend.contact-manager.show'
                    )
                );
    Route::get('contact-manager/{id}/edit/{form_id}',
                    array(
                        'uses' => 'Components\ContactManager\Controllers\Backend\ContactController@edit',
                        'as' => 'backend.contact-manager.edit'
                    )
                );
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
    Route::resource('menu-positions', 'Backend\MenuPositionsController');

    Route::resource('form', 'FormController', array('only'=>array('index', 'store', 'show', 'destroy')));
    Route::get('form/{id}/list', 'FormController@index');

    Route::resource('form-builder', 'Backend\FormBuilderController');
    Route::resource('form-categories', 'Backend\FormCategoriesController');

    Route::post('users/{id}/activate', array('as' => 'admin.users.activate', 'uses' => 'Backend\UserController@activate'));
    Route::post('users/{id}/deactivate', array('as' => 'admin.users.deactivate', 'uses' => 'Backend\UserController@deactivate'));

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
    Route::get('module-builder/form-dropdowns/{id}', 'Backend\ModuleBuilderController@getFormDropdowns');
    Route::resource('module-builder', 'Backend\ModuleBuilderController');

    Route::resource('slideshow', 'Modules\Slideshow\Controllers\Backend\SlideshowController');

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

    Route::get('report-builder/module-fields/{id}', 'Components\ReportBuilder\Controllers\Backend\ReportBuilderController@getModuleFields');
    Route::resource('report-builder', 'Components\ReportBuilder\Controllers\Backend\ReportBuilderController');
    Route::get('report-generators/generate/{id}', 'Components\ReportGenerator\Controllers\Backend\ReportGeneratorController@getGenerate');
    Route::post('report-generators/generate/{id}', array('uses' => 'Components\ReportGenerator\Controllers\Backend\ReportGeneratorController@postGenerate', 'as' => 'admin.report-generators.generate'));
    Route::resource('report-generators', 'Components\ReportGenerator\Controllers\Backend\ReportGeneratorController');

    Route::resource('contact-categories', 'Components\ContactManager\Controllers\Backend\ContactCategoriesController');

    Route::resource('contact-manager',
                    'Components\ContactManager\Controllers\Backend\ContactController');
    Route::get('contact-manager/create/{form_id}',
                    array(
                        'uses' => 'Components\ContactManager\Controllers\Backend\ContactController@create',
                        'as' => 'backend.contact-manager.create'
                    )
                );
    Route::get('contact-manager/{id}/{form_id}',
                    array(
                        'uses' => 'Components\ContactManager\Controllers\Backend\ContactController@show',
                        'as' => 'backend.contact-manager.show'
                    )
                );
    Route::get('contact-manager/{id}/edit/{form_id}',
                    array(
                        'uses' => 'Components\ContactManager\Controllers\Backend\ContactController@edit',
                        'as' => 'backend.contact-manager.edit'
                    )
                );
});

require_once(__DIR__ . '/errors.php');
