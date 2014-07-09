<?php namespace Components\ThemeManager\Services;
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
use Artisan, App, Exception, File, Input, Str, View, Redirect, Response, Validator;
use Sentry;

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
        $this->file = $input['file'];
    }

    public function installTheme()
    {
        try {
            $this->full_path = $this->extractToTemporary();

            $success = $this->getAndCheckConfig();

            $this->copyFiles();

            $this->copyScreenshot();

            $theme = \Theme::create(array(
                    'name'        => $this->config['name'],
                    'version'     => $this->config['version'],
                    'author'      => $this->config['author'],
                    'description' => $this->config['description'],
                    'directory'   => $this->config['directory'],
                    'screenshot'  => $this->screenshot,
                    'target'      => $this->target
                ));

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

        if (isset($this->config['screenshot']) && $this->config['screenshot'] != '') {
            $this->screenshot = "uploads/themes/{$this->theme_directory}_{$this->config['screenshot']}";
        } else {
            $this->screenshot = '';
        }
    }

    /**
     * Copy the extracted files to their respective directory
     * @return [type] [description]
     */
    protected function copyFiles()
    {
        $status = File::copyDirectory("{$this->full_path}{$this->theme_directory}/views/", app_path() . '/views/' . $this->target . '/' . $this->theme_directory . '/');

        File::copyDirectory("{$this->full_path}{$this->theme_directory}/assets/", public_path() . '/assets/' . $this->target . '/' . $this->theme_directory . '/');
    }

    protected function copyScreenshot()
    {
        if ($this->screenshot == '') {
            return;
        }
        File::exists(public_path() . '/uploads/') || File::makeDirectory(public_path() . '/uploads/');
        File::exists(public_path() . '/uploads/themes/') || File::makeDirectory(public_path() . '/uploads/themes/');

        File::copy($this->full_path . $this->config['screenshot'], $this->screenshot);
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
