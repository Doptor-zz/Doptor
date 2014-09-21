<?php namespace Services;
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
use Artisan, App, Event, Exception, Input, Str, View, Redirect, Response, Validator;
use Group;
use Sentry;

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

            if ($db_connection->select_db($input['DB_NAME']) === false) {
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
            @ini_set('max_execution_time', 300);     // Temporarily increase maximum execution time
            if (isset($input['sample_data']) && $input['sample_data']=='true') {
                $file = file_get_contents(app_path() . "/database/sample_data.sql");

                // \DB::statement("SET foreign_key_checks = 0");
                // Execute the whole sql statements in the sql file
                \DB::unprepared($file);
                $this->createSuperAdmin($input);
            } else {
                // Migrate all the tables
                Artisan::call('migrate');
                Artisan::call('migrate', array('--path' => 'app/components/posts/database/migrations/'));
                Artisan::call('migrate', array('--path' => 'app/modules/Slideshow/Database/migrations/'));
                Artisan::call('migrate', array('--path' => 'app/components/media_manager/database/migrations/'));
                Artisan::call('migrate', array('--path' => 'app/components/theme_manager/database/migrations/'));
                Artisan::call('migrate', array('--path' => 'app/components/ContactManager/Database/Migrations/'));
                Artisan::call('migrate', array('--path' => 'app/components/ReportBuilder/Database/Migrations/'));
                Artisan::call('migrate', array('--path' => 'app/components/ReportGenerator/Database/Migrations/'));

                $this->createSuperAdmin($input);

                Artisan::call('db:seed', array('--class' => 'MenuPositionTableSeeder'));
            }

        } catch (Exception $e) {
            return $this->listener->installerFails($e->getMessage());
        }

        Event::fire('installer.delete');
        return Redirect::to('/');
    }

    /**
     * Check whether or not, the current PHP installation is compatible
     * with the requirements or not
     */
    public function checkCompatibility()
    {
        if (!version_compare(phpversion(), '5.3.7', '>=')) {
            return $this->listener->installerFails('PHP version must be at least 5.3.7');
        }

        if (!extension_loaded('fileinfo')) {
            return $this->listener->installerFails('php_fileinfo plugin must be enabled');
        }

        if (!extension_loaded('curl')) {
            return $this->listener->installerFails('The PHP cURL extension must be installed');
        }

        if (!extension_loaded('zip')) {
            return $this->listener->installerFails('The zip extension must be enabled');
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

        foreach ($input as $key => $value) {
            $_ENV[$key] = $value;
        }

        if (app()->environment() == 'local') {
            $file = base_path() . '/.env.local.php';
        } else {
            $file = base_path() . '/.env.php';
        }
        file_put_contents($file, "<?php \n\n return " . var_export($_ENV, true) . ";");
    }
}
