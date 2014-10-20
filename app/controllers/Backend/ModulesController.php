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
                    ->with('success_message', 'The module was installed.');
            } else {
                return Redirect::to('backend/modules')
                    ->with('success_message', 'The module wasn\'t installed.');
            }

       } catch (Exception $e) {
           return Redirect::back()
               ->withInput()
               ->with('error_message', 'The module wasn\'t installed. ' . $e->getMessage());
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

        $module_tables = explode('|', $module->table);

        foreach ($module_tables as $module_table) {
            $sql = "DROP TABLE IF EXISTS mdl_{$module_table}";
            DB::statement($sql);
        }

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
