<?php namespace Backend;

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
use DB;
use Exception;
use File;
use Input;
use Redirect;
use Str;
use View;

use Module;
use Services\ModuleInstaller;

class ModulesController extends AdminController {

    function __construct(ModuleInstaller $moduleInstaller)
    {
        parent::__construct();
        $this->moduleInstaller = $moduleInstaller;
    }

    /**
     * Display a listing of the installed modules.
     *
     */
    public function getIndex()
    {
        $modules = Module::latest()->get();

        $this->layout->title = 'All Modules';
        $this->layout->content = View::make($this->link_type . '.' . $this->current_theme . '.modules.index')
            ->with('modules', $modules);
    }

    /**
     * Show the menu for creating a new installed module.
     *
     */
    public function getInstall()
    {
        $this->layout->title = 'Install New Module';
        $this->layout->content = View::make($this->link_type . '.' . $this->current_theme . '.modules.create_edit');
    }

    /**
     * Store a newly created installed module in storage.
     *
     */
    public function postInstall()
    {
       try {
            $file = Input::file('file');

            $input = $this->moduleInstaller->installModule($file);

            if ($module = Module::where('alias', '=', $input['alias'])->first()) {
                $module->update($input);
            } else {
                $module = Module::create($input);
            }

            if ($module) {
                return Redirect::to('backend/modules')
                    ->with('success_message', trans('success_messages.module_install'));
            } else {
                return Redirect::to('backend/modules')
                    ->with('error_message', trans('error_messages.module_install'));
            }

        } catch (Exception $e) {
            return Redirect::back()
                ->withInput()
                ->with('error_message', trans('error_messages.module_install') . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($id)
    {
        $module = Module::findOrFail($id);

        $this->revertMigrations($module);

        if ($module->alias == '') {
            $module->alias = str_replace(' ', '', Str::title($module->name));
        }

        if ($module->vendor) {
            $vendor_dir = app_path('/Modules/' . $module->vendor) . '/';
            $module_dir = $vendor_dir . $module->alias . '/';
        } else {
            $module_dir = app_path('/Modules/' . $module->alias) . '/';
        }

        $module_file = $module_dir . $module->alias . '.zip';

        File::exists($module_file) && File::delete($module_file);
        File::exists($module_dir) && File::deleteDirectory($module_dir);

        if (isset($vendor_dir) && count(glob($vendor_dir . '*'), GLOB_NOSORT) == 0) {
            // Delete the vendor directory also, if it is empty
            File::exists($vendor_dir) && File::deleteDirectory($vendor_dir);
        }

        if ($module->delete()) {
            return Redirect::to('backend/modules')
                ->with('success_message', trans('success_messages.module_delete'));
        } else {
            return Redirect::to('backend/modules')
                ->with('error_message', trans('error_messages.module_delete'));
        }
    }

    /**
     * Revert the migrations and database tables created by the module
     * @param  Object $module
     */
    private function revertMigrations($module)
    {
        $migrations = json_decode($module->migrations);
        $module_tables = explode('|', $module->table);

        if (is_array($migrations)) {
            // to run the migration in descending order
            rsort($migrations);

            // Delete all migration entries for the module
            foreach ($migrations as $migration_file) {
                if ($module->vendor) {
                    $migration_filename = app_path("Modules/{$module->vendor}/{$module->alias}/Database/Migrations/{$migration_file}.php");
                } else {
                    $migration_filename = app_path("Modules/{$module->alias}/Database/Migrations/{$migration_file}.php");
                }
                require_once($migration_filename);

                $file = implode('_', array_slice(explode('_', $migration_file), 4));
                $class_name = studly_case($file);
                $class = new $class_name;

                // Run the down method in the migration file
                $class->down();

                DB::table('migrations')->where('migration', $migration_file)->delete();
            }
        }

        // Drop all tables created by the module
        foreach ($module_tables as $module_table) {
            $vendor = Str::lower($module->vendor);
            $sql = "DROP TABLE IF EXISTS mdl_{$vendor}_{$module_table}";
            DB::statement($sql);
        }
    }
}
