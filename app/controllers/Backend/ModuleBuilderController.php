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
use App;
use BuiltForm;
use BuiltModule;
use Exception;
use File;
use Input;
use Redirect;
use Response;
use Services\ModuleBuilder;
use Str;
use View;

class ModuleBuilderController extends AdminController {

    function __construct(ModuleBuilder $moduleBuilder)
    {
        parent::__construct();
        $this->moduleBuilder = $moduleBuilder;
    }

    /**
     * Display a listing of the modules.
     */
    public function index()
    {
        $modules = BuiltModule::all();
        $this->layout->title = 'All Built Modules';
        $this->layout->content = View::make($this->link_type.'.' . $this->current_theme . '.module_builders.index')
            ->with('modules', $modules);
    }

    /**
     * Show the form for creating a new module.
     */
    public function create()
    {
        $this->layout->title = 'Create New Module';
        $this->layout->content = View::make($this->link_type.'.' . $this->current_theme . '.module_builders.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
       try {
            $input = Input::all();

            $validator = BuiltModule::validate($input);

            if ($validator->passes()) {
                $zip_file = $this->moduleBuilder->createModule($input);
                $file_name = Str::slug($input['name'], '_');

                $input = $this->formatInput($zip_file, $input);

                BuiltModule::create($input);

                App::finish(function ($request, $response) use ($zip_file) {
                    // Delete the file, as soon as it is downloaded
                    File::delete($zip_file);
                });

                return Response::download($zip_file, $file_name);
            } else {
                // Form validation failed
                return Redirect::back()
                    ->withInput()
                    ->withErrors($validator);
            }
        } catch (Exception $e) {
            return Redirect::back()
            ->withInput()
            ->with('error_message', 'The module wasn\'t created. ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the module.
     * @param  int $id
     */
    public function edit($id)
    {
        $module = BuiltModule::findOrFail($id);

        $selected_forms = explode(', ', $module->form_id);

        if (($key = array_search('0', $selected_forms)) !== false) {
            // Remove forms with id 0
            unset($selected_forms[$key]);
        }

        $select = array('Same as in form');
        $all_modules = BuiltModule::latest()->get(array('id', 'name', 'form_id'));
        foreach ($all_modules as $this_module) {
            $form_ids = explode(', ', $this_module->form_id);
            foreach ($form_ids as $form_id) {
                $form = BuiltForm::find($form_id);
                $select[$this_module->name][$form->id] = $form->name;
            }
        }

        $this->layout->title = 'Edit Existing Built Module';
        $this->layout->content = View::make($this->link_type.'.' . $this->current_theme . '.module_builders.create_edit')
            ->with('module', $module)
            ->with('selected_forms', $selected_forms)
            ->with('select', $select);
    }

    /**
     * Update the specified menu entry in storage.
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function update($id)
    {
        try {
            $input = Input::all();

            $validator = BuiltModule::validate($input, $id);

            if ($validator->passes()) {
                $zip_file = $this->moduleBuilder->createModule($input);
                $file_name = Str::slug($input['name'], '_');

                $input = $this->formatInput($zip_file, $input);

                $module = BuiltModule::findOrFail($id);
                $module->update($input);

                App::finish(function ($request, $response) use ($zip_file) {
                    // Delete the file, as soon as it is downloaded
                    File::delete($zip_file);
                });

                return Response::download($zip_file, $file_name);
            } else {
                // Form validation failed
                return Redirect::back()
                    ->withInput()
                    ->withErrors($validator);
            }
        } catch (Exception $e) {
            return Redirect::back()
            ->withInput()
            ->with('error_message', 'The module wasn\'t updated. ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified module from storage.
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $module = BuiltModule::findOrFail($id);

        if (!$module) App::abort('404');

        File::delete($module->file);
        if ($module->delete()) {
            return \Redirect::to($this->link_type."/module-builder")
                ->with('success_message', 'The module was deleted.');
        } else {
            return \Redirect::to($this->link_type."/module-builder")
                ->with('error_message', 'The module was not deleted.');
        }

    }

    public function download($id)
    {
        $module = BuiltModule::findOrFail($id);

        $canonical = Str::slug($module->name, '_');
        $zip_file = File::exists($module->file);

        if (!$zip_file) {
            return Redirect::to($this->link_type."/module-builder/{$id}/edit")
                ->with('error_message', 'The download file couldn\'t be found. Follow following steps to create and download the module file.');
        }

        return Response::download($zip_file, $canonical);
    }

    /**
     * Get all the dropdown fields, for the form
     * @param $form_id
     * @return array
     */
    public function getFormDropdowns($form_id)
    {
        return $this->moduleBuilder->getFormSelects($form_id);
    }

    /**
     * Get al the form fields in a form as an associative array
     * @param $id
     * @return array
     */
    public function getFormFields($id)
    {
        $form = BuiltForm::find($id);

        $form_fields = $this->moduleBuilder->getFormFields($form->data);

        $ret = array_combine($form_fields['fields'], $form_fields['field_names']);

        return $ret;
    }

    /**
     * Format the input parameters, so as to make them ready for saving to DB
     * @param $zip_file
     * @param $input
     */
    private function formatInput($zip_file, $input)
    {
        $input['file'] = $zip_file;
        $input['target'] = implode(', ', $input['target']);

        $form_ids = array_pluck($this->moduleBuilder->selected_forms, 'form_id');
        $input['form_id'] = implode(', ', $form_ids);

        $table_names = array_pluck($this->moduleBuilder->selected_forms, 'table');
        $input['table_name'] = implode('|', $table_names);

        return $input;
    }
}
