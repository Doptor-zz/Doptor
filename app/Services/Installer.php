<?php namespace Services;
error_reporting(E_ALL);
            ini_set('display_errors', 1);
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
use Artisan, App, DB, Event, Exception, Input, Str, View, Redirect, Response, Validator;
use Group;
use Sentry;

use App\Events\InstallationWasCompleted;

class Installer {

    protected $listener;

    public function __construct($listener)
    {
        $this->listener = $listener;
    }

    /**
     * Check connections to the database
     */
    public function dbConnection($input)
    {
        $incompatible = $this->checkCompatibility();

        if ($incompatible) {
            return $incompatible;
        }

        try {
            $db_connection = new \mysqli($input['DB_HOST'], $input['DB_USERNAME'], $input['DB_PASSWORD']);

            if ($db_connection->select_db($input['DB_DATABASE']) === false) {
                if (mysqli_error($db_connection) != '') {
                    return $this->listener->installerFails(mysqli_error($db_connection));
                }
            }

            $input['DB_TYPE'] = 'mysql';
            $this->setEnvironmentVariables($input);
        } catch (Exception $e) {
            return $this->listener->installerFails($e->getMessage());
        }

        return $this->listener->installerSucceeds('install/2');
    }

    public function dbMigrate($input)
    {
        $rules = array(
                'username'              => 'required',
                'email'                 => 'required|email',
                'first_name'            => 'required',
                'last_name'             => 'required',
                'password'              => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6',
            );

        $messages = array();

        $validation = Validator::make($input, $rules, $messages);

        if ($validation->fails()) {
            return $this->listener->validationErrors($validation->messages());
        }

        $env = array('TIME_ZONE' => $input['time_zone']);
        $this->setEnvironmentVariables($env);

        try {
            @ini_set('max_execution_time', 0);     // Temporarily increase maximum execution time

            Artisan::call('vendor:publish', ['--provider' => 'Barryvdh\TranslationManager\ManagerServiceProvider', '--tag' => ['migrations']]);

            // Migrate all the tables
            Artisan::call('migrate');

            Artisan::call('vendor:publish', ['--provider' => 'Barryvdh\TranslationManager\ManagerServiceProvider', '--tag' => ['config']]);

            Artisan::call('migrate', ['--path' => 'app/Components/posts/database/migrations/']);
            Artisan::call('migrate', ['--path' => 'app/Modules/Doptor/Slideshow/Database/Migrations/']);
            Artisan::call('migrate', ['--path' => 'app/Components/MediaManager/database/migrations/']);
            Artisan::call('migrate', ['--path' => 'app/Components/theme_manager/database/migrations/']);
            Artisan::call('migrate', ['--path' => 'app/Components/ContactManager/Database/Migrations/']);
            Artisan::call('migrate', ['--path' => 'app/Components/ReportBuilder/Database/Migrations/']);
            Artisan::call('migrate', ['--path' => 'app/Components/ReportGenerator/Database/Migrations/']);
            Artisan::call('migrate', ['--path' => 'app/Modules/Doptor/CompanyInfo/Database/Migrations/']);
            Artisan::call('migrate', ['--path' => 'app/Modules/Doptor/TranslationManager/Database/Migrations/']);

            $this->createSuperAdmin($input);

            if (isset($input['sample_data']) && $input['sample_data']=='true') {
                // Install sample seed data
                Artisan::call('db:seed');
            }

            Artisan::call('db:seed', ['--class' => 'MenuPositionTableSeeder']);
            Artisan::call('db:seed', ['--class' => 'ThemesTableSeeder']);

            Artisan::call('db:seed', ['--class' => 'Modules\Doptor\CompanyInfo\Database\Seeds\CountriesTableSeeder']);
            Artisan::call('db:seed', ['--class' => 'Modules\Doptor\TranslationManager\Database\Seeds\ModulesTableSeeder']);
            Artisan::call('db:seed', ['--class' => 'Modules\Doptor\TranslationManager\Database\Seeds\LanguageTableSeeder']);
            Artisan::call('db:seed', ['--class' => 'Modules\Doptor\CompanyInfo\Database\Seeds\ModulesTableSeeder']);
            Artisan::call('db:seed', ['--class' => 'Modules\Doptor\Slideshow\Database\Seeds\ModulesTableSeeder']);

        } catch (Exception $e) {
            return $this->listener->installerFails($e->getMessage());
        }

        Event::fire(new InstallationWasCompleted());
        return Redirect::to('/');
    }

    /**
     * Check whether or not, the current PHP installation is compatible
     * with the requirements or not
     */
    public function checkCompatibility()
    {
        if (!version_compare(phpversion(), '5.5.9', '>=')) {
            return $this->listener->installerFails('PHP version must be at least 5.5.9');
        }

        $required_extensions = array(
                'fileinfo',
                'curl',
                'zip',
                'openssl',
                'mbstring',
                'tokenizer'
            );

        foreach ($required_extensions as $extension) {
            if (!extension_loaded($extension)) {
                return $this->listener->installerFails("$extension PHP Extension must be enabled");
            }
        }
    }

    /**
     * Create an user with superadmin privileges
     * @param  array $input Input
     */
    public function createSuperAdmin($input)
    {
        $user = Sentry::createUser(array(
            'username'   => $input['username'],
            'email'      => $input['email'],
            'password'   => $input['password'],
            'first_name' => $input['first_name'],
            'last_name'  => $input['last_name'],
            'activated'  => 1,
        ));

        $group_exists = Group::where('name', 'Super Administrators')->first();

        if (!$group_exists) {
            // Create the group only if it doesn't already exist
            $group = Sentry::createGroup(array(
                'name'        => 'Super Administrators',
                'permissions' => array(
                    'superuser' => 1
                ),
            ));
        }

        // Assign user permissions
        $userGroup = Sentry::findGroupByName('Super Administrators');
        $user->addGroup($userGroup);
    }

    /**
     * Set the environment variables as per configuration
     * @param array $input The input from configuration
     */
    public function setEnvironmentVariables($input)
    {
        if (isset($input['_token'])) unset($input['_token']);
        $env_content = '';
        $file = base_path() . '/.env';

        foreach ($input as $key => $value) {
            $env_content .= "$key=$value\n";
        }

        file_put_contents($file, $env_content, FILE_APPEND);
    }
}
