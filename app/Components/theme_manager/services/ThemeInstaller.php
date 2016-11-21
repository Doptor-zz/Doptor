<?php namespace Components\ThemeManager\Services;
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
use Artisan, App, Exception, File, Input, Str, View, Redirect, Response, Validator;
use Sentry;

use Module;
use Theme;
use \Services\ModuleInstaller;

class ThemeInstaller {

    protected $listener;
    protected $file;
    protected $screenshot;
    protected $full_path;
    protected $theme_directory;

    public function __construct($listener, $input)
    {
        $this->listener = $listener;

        $this->target = $input['target'];
        $this->file = isset($input['file']) ? $input['file'] : null;
        $this->install_sample_data = isset($input['install_sample_data']) && $input['install_sample_data'];
    }

    public function installTheme()
    {
        try {
            $this->full_path = $this->extractToTemporary();
            $success = $this->getAndCheckConfig();
            $this->copyFiles();

            $this->copyScreenshot();

            $theme = Theme::create(array(
                    'name'         => $this->config['name'],
                    'version'      => $this->config['version'],
                    'author'       => $this->config['author'],
                    'description'  => $this->config['description'],
                    'directory'    => $this->config['directory'],
                    'screenshot'   => $this->screenshot,
                    'target'       => $this->target,
                    'has_settings' => $this->has_settings
                ));

            $this->installModules();

            if ($this->install_sample_data) {
                $this->installSampleData($theme);
            }

            $this->cleanup();

            return $this->listener->installerSucceeds('backend/theme-manager', 'The theme was installed successfully');
        } catch (Exception $e) {
            return $this->listener->installerFails($e->getMessage());
        }
    }

    protected function extractToTemporary()
    {
        $this->filename = $this->file->getClientOriginalName();
        $extension = $this->file->getClientOriginalExtension();

        if ($extension == '') {
            $this->filename = $this->filename . '.zip';
            $extension = 'zip';
        }

        $temp_directory = str_replace('.'.$extension, '', $this->filename);

        // Upload the theme zip file to temporary folder
        $uploadSuccess = Input::file('file')->move(temp_path() . '/', $this->filename);

        $file = temp_path() . '/' . $this->filename;

        // get the absolute path to $file
        // $path = pathinfo(realpath($file), PATHINFO_DIRNAME) . '/';

        $full_path = pathinfo(realpath($file), PATHINFO_DIRNAME) . '/' . $temp_directory . '/';

        $unzipSuccess = $this->Unzip($file, $full_path);

        return $full_path;
    }

    /**
     * Get the configuration file from the temporary folder,
     * get its content
     */
    protected function getAndCheckConfig()
    {
        $this->config = json_decode(file_get_contents($this->full_path . 'theme.json'), true);
        if (!isset($this->config['directory'])) {
            throw new Exception('No directory was specified in the theme.json file inside the theme package. <br> A directory containing the theme files must be specified in the theme package.');
        }

        if (!File::exists("{$this->full_path}{$this->config['directory']}/")) {
            throw new Exception('The directory specified in the theme.json was not found in the theme package.');
        }

        $this->theme_directory = $this->config['directory'];

        $this->has_settings = isset($this->config['has_settings']) ? $this->config['has_settings'] : false;
    }

    /**
     * Copy the extracted files to their respective directory
     * @return [type] [description]
     */
    protected function copyFiles()
    {
        $status = File::copyDirectory("{$this->full_path}{$this->theme_directory}/views/", base_path() . '/resources/views/' . $this->target . '/' . $this->theme_directory . '/');

        File::copyDirectory("{$this->full_path}{$this->theme_directory}/assets/", public_path() . '/assets/' . $this->target . '/' . $this->theme_directory . '/');
    }

    protected function copyScreenshot()
    {
        if (isset($this->config['screenshot']) && $this->config['screenshot'] != '') {
            $this->screenshot = "uploads/themes/{$this->theme_directory}_{$this->config['screenshot']}";
        } else {
            $this->screenshot = '';
            return;
        }

        File::exists(public_path() . '/uploads/') || File::makeDirectory(public_path() . '/uploads/');
        File::exists(public_path() . '/uploads/themes/') || File::makeDirectory(public_path() . '/uploads/themes/');

        File::copy($this->full_path . $this->config['screenshot'], public_path() . '/' . $this->screenshot);
    }

    /**
     * Install all modules bundled with the theme
     */
    protected function installModules()
    {
        if (!isset($this->config['modules'])) {
            return false;
        }

        $modules = $this->config['modules'];

        $module_installer = new ModuleInstaller;

        foreach ($modules as $module) {
            $module_dir = "{$this->full_path}modules/{$module}/";
            if (file_exists($module_dir) && file_exists($module_dir . 'module.json')) {
                $module_data = $module_installer->installModule($module_dir);

                if ($module = Module::where('alias', '=', $module_data['alias'])->first()) {
                    $module->update($module_data);
                } else {
                    $module = Module::create($module_data);
                }
            }
        }
    }

    /**
     * Install sample data present in the theme
     */
    protected function installSampleData($theme)
    {
        $this->backupDatabase();

        $this->seedDatabase($theme);

        $this->copySampleUploads();
    }

    protected function backupDatabase()
    {
        if (!File::exists(stored_backups_path())) {
            File::makeDirectory(stored_backups_path());
        }

        $this->current_time = date("Y-m-d-H-i-s");
        $this->backup_file = stored_backups_path() . "/backup_{$this->current_time}.zip";

        $synchronizer = new \Services\Synchronize($this);

        $synchronizer->startBackup(true, false, false);

        $backup_description = 'Backup created before installing ' . $this->config['name'];
        $synchronizer->saveBackupToDB($backup_description);
    }

    /**
     * Seed the database using theme sample data
     */
    protected function seedDatabase($theme)
    {
        $seed_dir = $this->full_path . 'sample_data/seeds';

        if (File::files($seed_dir)) {
            foreach (File::files($seed_dir) as $file) {
                require_once($file);
            }
            $seeder = new \ThemeSeeder($theme);
            $seeder->run();
        }
    }

    /**
     * Copy the sample uploads(images, pdfs...) in the theme
     */
    protected function copySampleUploads()
    {
        $theme_sample_uploads = $this->full_path . 'sample_data/uploads';

        if (File::exists($theme_sample_uploads)) {
            $sample_uploads_dir = public_path('uploads/sample/' . $this->config['directory']);

            File::copyDirectory($theme_sample_uploads, $sample_uploads_dir);
        }
    }

    /**
     * Cleans up the temporary files/folders from temporary directory
     */
    public function cleanup()
    {
        File::deleteDirectory($this->full_path);
        File::delete(temp_path() . '/' . $this->filename);
    }

    protected function Unzip($file, $path)
    {
        // if(!is_file($file) || !is_readable($path)) {
        //     return \Redirect::to('backend/modules')
        //                         ->with('error_message', "Can't read input file");
        // }

        // if(!is_dir($path) || !is_writable($path)) {
        //     return \Redirect::to('backend/modules')
        //                         ->with('error_message', "Can't write to target");
        // }

        $zip = new \ZipArchive;
        $res = $zip->open($file);
        if ($res === TRUE) {
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
}