<?php namespace Backend;

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
use Config;
use DB;
use Exception;
use File;
use Input;
use Redirect;
use Schema;
use Str;
use View;

use Module;

class ModulesController extends AdminController {

    /**
     * Display a listing of the installed modules.
     *
     * @return Response
     */
    public function getIndex()
    {
        $modules = Module::all();

        $this->layout->title = 'All Modules';
        $this->layout->content = View::make($this->link_type . '.' . $this->current_theme . '.modules.index')
            ->with('modules', $modules);
    }

    /**
     * Show the menu for creating a new installed module.
     *
     * @return Response
     */
    public function getInstall()
    {
        $this->layout->title = 'Install New Module';
        $this->layout->content = View::make($this->link_type . '.' . $this->current_theme . '.modules.create_edit');
    }

    /**
     * Store a newly created installed module in storage.
     *
     * @return Response
     */
    public function postInstall()
    {
        try {
            $file = Input::file('file');
            $modules_path = app_path() . '/modules/';
            $temp_path = temp_path() . '/';
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            if ($extension == '') {
                $filename = $filename . '.zip';
                $extension = 'zip';
            }

            $file = $temp_path . $filename;
            File::exists($file) && File::delete($file);

            // Upload the module zip file to temporary folder
            $uploadSuccess = Input::file('file')->move($temp_path, $filename);

            // get the absolute path to $file
            $temporary_path = pathinfo(realpath($file), PATHINFO_DIRNAME) . '/';

            $canonical = str_replace('.' . $extension, '', $filename);

            $unzipSuccess = $this->Unzip($file, "{$temporary_path}{$canonical}");

            $temporary_path = pathinfo(realpath($file), PATHINFO_DIRNAME) . '/' . $canonical . '/';
            if (!File::exists($temporary_path . 'module.json')) {
                return Redirect::back()
                    ->with('error_message', 'module.json doesn\'t exist in the module');
            }

            $config = json_decode(file_get_contents($temporary_path . 'module.json'), true);

            $replace_existing = (bool)Input::get('replace_existing');
            if (Module::where('name', '=', $config['info']['name'])->first()
                    && !$replace_existing) {
                return Redirect::back()
                    ->with('error_message', 'Another module with the same name already exists');
            }

            // Copy modules from temporary folder to modules folder
            File::copyDirectory("{$temporary_path}{$config['info']['canonical']}/",
                "{$modules_path}{$config['info']['canonical']}/");
            File::copy("{$temporary_path}module.json",
                "{$modules_path}{$config['info']['canonical']}/module.json");

            File::deleteDirectory($temporary_path);

            File::delete($file);

            $db_name = Config::get('database.connections.mysql.database');
            $input = array(
                'name'    => $config['info']['name'],
                'alias'   => $config['info']['canonical'],
                'version' => $config['info']['version'],
                'author'  => $config['info']['author'],
                'website' => $config['info']['website'],
                'table'   => $config['table'],
                'target'  => $config['target'],
                'enabled' => true
            );

            if (!Schema::hasTable("module_{$config['table']}")) {
                $create_sql = "create table if not exists `module_{$config['table']}`";
                $create_sql .= "(`id` int(10) unsigned NOT NULL AUTO_INCREMENT, ";
                foreach ($config['fields'] as $field) {
                    $create_sql .= "`$field` text COLLATE utf8_unicode_ci NULL, ";
                }
                $create_sql .= "`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00', `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00', PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;";
                DB::statement($create_sql);

                $module = Module::create($input);
            } else {
                $alter_sql = "ALTER TABLE module_{$config['table']} ";
                $add_columns = array();
                foreach ($config['fields'] as $field) {
                    if (!Schema::hasColumn("module_{$config['table']}", $field)) {
                        $add_columns[] = "ADD COLUMN `{$field}` text COLLATE utf8_unicode_ci NULL AFTER `{$previous_field}`";
                    }
                    $previous_field = $field;
                }
                $alter_sql .= implode(', ', $add_columns) . ';';
                DB::unprepared($alter_sql);

                $module = Module::where('table', '=', $config['table'])->first();

                $module->update($input);
            }

            if ($module) {
                return Redirect::to('backend/modules')
                    ->with('success_message', 'The module was installed.');
            } else {
                return Redirect::to('backend/modules')
                    ->with('success_message', 'The module wasn\'t installed.');
            }

        } catch (Exception $e) {
            return Redirect::to('backend/modules')
                ->with('error_message', 'The module wasn\'t installed. ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function getDelete($id)
    {
        $module = Module::findOrFail($id);

        if ($module) {
            $sql = "DROP TABLE IF EXISTS module_$module->table";
            DB::statement($sql);

            $module_alias = str_replace(' ', '', Str::title($module->name));

            $module_dir = app_path() . '/modules/' . $module_alias . '/';
            $module_file = $module_dir . $module_alias . '.zip';

            File::exists($module_file) && File::delete($module_file);
            File::exists($module_dir) && File::deleteDirectory($module_dir);

            if ($module->delete()) {
                return Redirect::to('backend/modules')
                    ->with('success_message', 'Module was deleted.');
            } else {
                return Redirect::to('backend/modules')
                    ->with('error_message', 'Module wasn\'t deleted.');
            }
        }
    }

    protected function Unzip($file, $path)
    {
        // if(!is_file($file) || !is_readable($path)) {
        //     return Redirect::to('backend/modules')
        //                         ->with('error_message', "Can't read input file");
        // }

        // if(!is_dir($path) || !is_writable($path)) {
        //     return Redirect::to('backend/modules')
        //                         ->with('error_message', "Can't write to target");
        // }

        $zip = new \ZipArchive;
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
}
