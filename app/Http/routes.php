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
Route::get('/', function () {
    if (!Schema::hasTable('settings') || Config::get('database.default') == 'sqlite') {

        // If not installed, redirect to install page
        return Redirect::to('install');
    } else {
        $default_menu = Menu::published()->default('public')->first();

        if (!$default_menu || $default_menu->link == '/') {
            return Redirect::action('HomeController@index');
        } else {
            $link = str_replace('link_type', '', $default_menu->link);

            return Redirect::to($link);
        }
    }
});

// Apply CSRF protection to every routes
// Route::when('*', array('csrf'));

Route::get('home', 'HomeController@index');
Route::get('wrapper/{id}', 'HomeController@wrapper');

Route::group(array('prefix' => 'install', 'middleware' => 'isInstalled'), function () {
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
Route::get('suspend_user/{id}/{token}', 'AuthController@suspendUser');

Route::post('contact', 'HomeController@postContact');

Route::get('contact/{category}', 'Components\ContactManager\Controllers\PublicController@showCategory');
Route::get('contact/{category}/{contact}', 'Components\ContactManager\Controllers\PublicController@showPublic');
Route::post('contact/{contact}/send', 'Components\ContactManager\Controllers\PublicController@sendMessage');

Route::resource('form', 'FormController', array('only' => array('store', 'show')));

Route::get('pages/category/{alias}', 'Components\Posts\Controllers\PostsController@category');
Route::resource('pages', 'Components\Posts\Controllers\PostsController');

Route::get('posts/category/{alias}', 'Components\Posts\Controllers\PostsController@category');
Route::resource('posts', 'Components\Posts\Controllers\PostsController');

/*
  |--------------------------------------------------------------------------
  | Backend Routes
  |--------------------------------------------------------------------------
*/
Route::group(array('prefix' => 'backend', 'middleware' => array('auth', 'auth.backend', 'auth.permissions', 'auth.pw_6_months')), function () {

    Route::any('/', 'Backend\HomeController@getIndex');
    Route::get('change_language/{lang}', 'Backend\HomeController@getChangeLang');
    Route::get('datatableLangfile', 'Backend\HomeController@getDatatableLangfile');
    Route::get('config', 'Backend\HomeController@getConfig');
    Route::post('config', array('uses' => 'Backend\HomeController@postConfig', 'as' => 'config'));

    Route::get('theme_settings', 'Backend\HomeController@getThemeConfig');
    Route::post('theme_settings', array('uses' => 'Backend\HomeController@postThemeConfig', 'as' => 'theme_settings'));

    Route::get('menu-manager/set-default/{menu_id}', [
            'uses' => 'Backend\MenuManagerController@setDefault',
            'as' => 'backend.menu-manager.set-default'
        ]);
    Route::resource('menu-manager', 'Backend\MenuManagerController');
    Route::resource('menu-categories', 'Backend\MenuCategoriesController');
    Route::resource('menu-positions', 'Backend\MenuPositionsController');

    Route::resource('form-builder', 'Backend\FormBuilderController');
    Route::resource('form-categories', 'Backend\FormCategoriesController');

    Route::resource('form', 'FormController', array('only' => array('index', 'store', 'show', 'destroy')));
    Route::get('form/{id}/list', 'FormController@index');

    Route::post('users/{id}/activate', array('as' => 'backend.users.activate', 'uses' => 'Backend\UserController@activate'));
    Route::post('users/{id}/deactivate', array('as' => 'backend.users.deactivate', 'uses' => 'Backend\UserController@deactivate'));
    Route::get('users/forgot_password', 'AuthController@postForgotPassword');

    // For changing the current user's password
    Route::get('users/change-password', 'Backend\UserController@getChangePassword');
    Route::put('users/change-password', array('uses' => 'Backend\UserController@putChangePassword',
    'as' => 'backend.users.change-password'));

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
    Route::get('profile', 'Backend\ProfileController@showProfile');
    Route::get('profile/edit', 'Backend\ProfileController@editProfile');

    Route::get('modules', array('as' => 'backend.modules.index', 'uses' => 'Backend\ModulesController@getIndex'));
    Route::get('modules/install', array('as' => 'backend.modules.create', 'uses' => 'Backend\ModulesController@getInstall'));
    Route::post('modules/install', array('as' => 'backend.modules.store', 'uses' => 'Backend\ModulesController@postInstall'));
    Route::delete('modules/delete/{id}', array('uses' => 'Backend\ModulesController@getDelete', 'as' => 'backend.modules.destroy'));

    Route::get('module-builder/download/{id}', 'Backend\ModuleBuilderController@download');
    Route::get('module-builder/form-dropdowns/{id}', 'Backend\ModuleBuilderController@getFormDropdowns');
    Route::get('module-builder/form-fields/{form_id}/{module_id?}', 'Backend\ModuleBuilderController@getFormFields');
    Route::resource('module-builder', 'Backend\ModuleBuilderController');

    // For pages and posts
    Route::resource('pages', 'Components\Posts\Controllers\Backend\PostsController');
    Route::resource('page-categories', 'Components\Posts\Controllers\Backend\PostCategoriesController');

    Route::resource('posts', 'Components\Posts\Controllers\Backend\PostsController');
    Route::resource('post-categories', 'Components\Posts\Controllers\Backend\PostCategoriesController');

    Route::any('media-manager/create_folder', 'Components\MediaManager\Controllers\Backend\MediaManagerController@create_folder');
    Route::any('media-manager/folder_contents', 'Components\MediaManager\Controllers\Backend\MediaManagerController@folder_contents');
    Route::resource('media-manager', 'Components\MediaManager\Controllers\Backend\MediaManagerController');

    Route::get('backup', 'Backend\BackupRestoreController@getBackup');
    Route::post('backup', 'Backend\BackupRestoreController@postBackup');
    Route::delete('backup/delete/{id}', array('uses' => 'Backend\BackupRestoreController@deleteBackup', 'as' => 'backups.destroy'));

    Route::get('restore', 'Backend\BackupRestoreController@getRestore');
    Route::get('restore/upload', 'Backend\BackupRestoreController@getRestoreFromFile');
    Route::post('restore',  array('uses' => 'Backend\BackupRestoreController@postRestore', 'as' => 'backups.restore'));

    Route::post('theme-manager/apply/{id}', array(
                                'uses' => 'Components\ThemeManager\Controllers\Backend\ThemeManagerController@apply',
                                'as' => 'backend.theme-manager.apply'
                            ));
    Route::resource('theme-manager', 'Components\ThemeManager\Controllers\Backend\ThemeManagerController');

    Route::get('report-builder/module-fields/{id}', 'Components\ReportBuilder\Controllers\Backend\ReportBuilderController@getModuleFields');
    Route::get('report-builder/download/{id}', 'Components\ReportBuilder\Controllers\Backend\ReportBuilderController@download');
    Route::resource('report-builder', 'Components\ReportBuilder\Controllers\Backend\ReportBuilderController');

    Route::get('report-generators/generate/{id}', 'Components\ReportGenerator\Controllers\Backend\ReportGeneratorController@getGenerate');
    Route::post('report-generators/generate/{id}', array('uses' => 'Components\ReportGenerator\Controllers\Backend\ReportGeneratorController@postGenerate', 'as' => 'backend.report-generators.generate'));
    Route::get('report-generators/install', 'Components\ReportGenerator\Controllers\Backend\ReportGeneratorController@create');
    Route::resource('report-generators', 'Components\ReportGenerator\Controllers\Backend\ReportGeneratorController');

    Route::resource('contact-categories', 'Components\ContactManager\Controllers\Backend\ContactCategoriesController');

    Route::resource('contact-manager', 'Components\ContactManager\Controllers\Backend\ContactController');
    Route::get('contact-manager/create/{form_id}', array('uses' => 'Components\ContactManager\Controllers\Backend\ContactController@create', 'as' => 'backend.contact-manager.create'));
    Route::get('contact-manager/{id}/{form_id}', array('uses' => 'Components\ContactManager\Controllers\Backend\ContactController@show', 'as' => 'backend.contact-manager.show'));
    Route::get('contact-manager/{id}/edit/{form_id}', array('uses' => 'Components\ContactManager\Controllers\Backend\ContactController@edit', 'as' => 'backend.contact-manager.edit'));
});

/*
  |--------------------------------------------------------------------------
  | Admin Routes
  |--------------------------------------------------------------------------
*/
Route::group(array('prefix' => 'admin'), function () {

    if (Schema::hasTable('menus')) {
        $default_menu = Menu::published()->default('admin')->first();

        if ($default_menu) {
            $link = str_replace('link_type', 'admin', $default_menu->link);
            Route::any('/', function() use ($link) {
                return Redirect::to($link);
            });
        } else {
            Route::any('/', 'Backend\HomeController@getIndex');
        }
    } else {
        Route::any('/', 'Backend\HomeController@getIndex');
    }

    Route::get('datatableLangfile', 'Backend\HomeController@getDatatableLangfile');
    Route::get('config', 'Backend\HomeController@getConfig');
    Route::post('config', array('uses' => 'Backend\HomeController@postConfig', 'as' => 'config'));

    Route::resource('menu-manager', 'Backend\MenuManagerController');
    Route::resource('menu-categories', 'Backend\MenuCategoriesController');
    Route::resource('menu-positions', 'Backend\MenuPositionsController');

    Route::resource('form', 'FormController', array('only' => array('index', 'store', 'show', 'destroy')));
    Route::get('form/{id}/list', 'FormController@index');

    Route::resource('form-builder', 'Backend\FormBuilderController');
    Route::resource('form-categories', 'Backend\FormCategoriesController');

    Route::post('users/{id}/activate', array('as' => 'admin.users.activate', 'uses' => 'Backend\UserController@activate'));
    Route::post('users/{id}/deactivate', array('as' => 'admin.users.deactivate', 'uses' => 'Backend\UserController@deactivate'));

    // For changing the current user's password
    Route::get('users/change-password', 'Backend\UserController@getChangePassword');
    Route::put('users/change-password', array('uses' => 'Backend\UserController@putChangePassword', 'as' => 'admin.users.change-password'));

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
    Route::get('profile', 'Backend\ProfileController@showProfile');
    Route::get('profile/edit', 'Backend\ProfileController@editProfile');

    Route::get('modules', array('as' => 'admin.modules.index', 'uses' => 'Backend\ModulesController@getIndex'));
    Route::get('modules/install', array('as' => 'admin.modules.create', 'uses' => 'Backend\ModulesController@getInstall'));
    Route::post('modules/install', array('as' => 'admin.modules.store', 'uses' => 'Backend\ModulesController@postInstall'));
    Route::delete('modules/delete/{id}', array('uses' => 'Backend\ModulesController@getDelete', 'as' => 'admin.modules.destroy'));

    Route::get('module-builder/download/{id}', 'Backend\ModuleBuilderController@download');
    Route::get('module-builder/form-dropdowns/{id}', 'Backend\ModuleBuilderController@getFormDropdowns');
    Route::resource('module-builder', 'Backend\ModuleBuilderController');

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
    Route::post('report-generators/generate/{id}', array(
                            'uses' => 'Components\ReportGenerator\Controllers\Backend\ReportGeneratorController@postGenerate',
                        'as' => 'admin.report-generators.generate'));
    Route::resource('report-generators', 'Components\ReportGenerator\Controllers\Backend\ReportGeneratorController');

    Route::resource('contact-categories', 'Components\ContactManager\Controllers\Backend\ContactCategoriesController');

    Route::resource('contact-manager', 'Components\ContactManager\Controllers\Backend\ContactController');
    Route::get('contact-manager/create/{form_id}', array(
                        'uses' => 'Components\ContactManager\Controllers\Backend\ContactController@create',
                        'as' => 'backend.contact-manager.create'
                    ));
    Route::get('contact-manager/{id}/{form_id}', array(
                        'uses' => 'Components\ContactManager\Controllers\Backend\ContactController@show',
                        'as' => 'backend.contact-manager.show'
                    ));
    Route::get('contact-manager/{id}/edit/{form_id}', array(
                        'uses' => 'Components\ContactManager\Controllers\Backend\ContactController@edit',
                        'as' => 'backend.contact-manager.edit'
                    ));
});

// Add the routes of installed modules
foreach (glob(base_path("app/Modules/*/routes.php")) as $route) {
    require_once ($route);
}

foreach (glob(base_path("app/Modules/*/*/routes.php")) as $route) {
    require_once ($route);
}
