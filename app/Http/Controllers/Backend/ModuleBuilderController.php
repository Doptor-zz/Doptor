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
use App;
use Exception;
use File;
use Input;
use Redirect;
use Response;
use Services\ModuleBuilder;
use Session;
use Str;
use View;

use BuiltForm;
use BuiltModule;
use Module;

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
        $modules = BuiltModule::visible()->latest()->get();
        $this->layout->title = 'All Built Modules';
        $this->layout->content = View::make($this->link_type . '.' . $this->current_theme . '.module_builders.index')
            ->with('modules', $modules);
    }

    /**
     * Show the form for creating a new module.
     */
    public function create()
    {
        $select = $this->formDropdownSources();
        $all_modules = Module::latest()->lists('name', 'id');

        $this->layout->title = 'Create New Module';
        $this->layout->content = View::make($this->link_type . '.' . $this->current_theme . '.module_builders.create_edit')
            ->with('all_modules', $all_modules)
            ->with('select', $select)
            ->with('selected_forms', [0]);
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
                $input['hash'] = uniqid('module_');
                $zip_file = $this->moduleBuilder->createModule($input);
                $file_name = Str::slug($input['name'], '_');

                $input = $this->formatInput($zip_file, $input);

                $built_module = BuiltModule::create($input);

                Session::put('download_file', $built_module->id);

                return Redirect::to('backend/module-builder')
                        ->with('success_message', trans('success_messages.module_create'));
            } else {
                // Form validation failed
                return Redirect::back()
                    ->withInput()
                    ->withErrors($validator);
            }
        } catch (Exception $e) {
            return Redirect::back()
                ->withInput()
                ->with('error_message', trans('error_messages.module_create') . ' ' . $e->getMessage());
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

        $select = $this->formDropdownSources($id);
        $all_modules = Module::latest()->lists('name', 'id');

        $this->layout->title = 'Edit Existing Built Module';
        $this->layout->content = View::make($this->link_type . '.' . $this->current_theme . '.module_builders.create_edit')
            ->with('all_modules', $all_modules)
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
                $module = BuiltModule::findOrFail($id);
                if ($module->hash == '') {
                    $input['hash'] = uniqid('module_');
                } else {
                    $input['hash'] = $module->hash;
                }
                $input['is_author'] = $module->is_author;
                if (!(bool) $module->is_author) {
                    $input['name'] = $module->name;
                    $input['author'] = $module->author;
                    $input['vendor'] = $module->vendor;
                    $input['version'] = $module->version;
                    $input['website'] = $module->website;
                    $input['description'] = $module->description;
                }

                $zip_file = $this->moduleBuilder->createModule($input);
                $file_name = Str::slug($input['name'], '_');

                $input = $this->formatInput($zip_file, $input);

                $module->update($input);

                Session::put('download_file', $id);

                return Redirect::to('backend/module-builder')
                        ->with('success_message', trans('success_messages.module_update'));
            } else {
                // Form validation failed
                return Redirect::back()
                    ->withInput()
                    ->withErrors($validator);
            }
        } catch (Exception $e) {
            return Redirect::back()
                ->withInput()
                ->with('error_message', trans('error_messages.module_update') . ' ' . $e->getMessage());
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
            return \Redirect::to($this->link_type . "/module-builder")
                ->with('success_message', trans('success_messages.module_delete'));
        } else {
            return \Redirect::to($this->link_type . "/module-builder")
                ->with('error_message', trans('error_messages.module_delete'));
        }

    }

    public function download($id)
    {
        Session::forget('download_file');
        $module = BuiltModule::findOrFail($id);

        $canonical = Str::slug($module->name, '_');
        $zip_file = $module->file;

        if (!File::exists($zip_file)) {
            return Redirect::to($this->link_type . "/module-builder/{$id}/edit")
                ->with('error_message', trans('error_messages.module_file_download'));
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
    public function getFormFields($id, $module_id=null)
    {
        $form_id = (int)$id;
        $ret = [];

        if ($form_id != 0) {
            // if form id is specified
            $form = BuiltForm::find($form_id);
            $form_fields = $this->moduleBuilder->getFormFields($form->data);

            $ret = array_combine($form_fields['fields'], $form_fields['field_names']);
        } else {
            if ($module_id) {
                $module = BuiltModule::find($module_id);
                $model = $id;

                $module_models = json_decode($module->models, true);
                $module_fields = json_decode($module->form_fields, true);

                $model_index = array_search($model, array_keys($module_models));

                if ($model_index !== false) {
                    $ret = $module_fields[$model_index];
                }
            }
        }

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

        $input['requires'] = isset($input['requires']) ? $input['requires'] : [];
        $input['requires'] = json_encode($input['requires']);

        return $input;
    }

    /**
     * @param $module_id
     * @return array
     */
    private function formDropdownSources($module_id=null)
    {
        $select = array('Same as in form');

        if ($module_id) {
            // Exclude the currently being edited module
            $all_modules = BuiltModule::whereNotIn('id', array($module_id))->latest();
        } else {
            $all_modules = BuiltModule::latest();
        }

        $all_modules = $all_modules->get(array('id', 'name', 'form_id', 'models'));
        foreach ($all_modules as $this_module) {
            if ($this_module->models) {
                $models = json_decode($this_module->models);
                foreach ($models as $model => $model_text) {
                    $select[$this_module->name][$this_module->id . '-' . $model] = $model_text;
                }
            } else {
                $form_ids = explode(', ', $this_module->form_id);
                foreach ($form_ids as $form_id) {
                    $form = BuiltForm::find($form_id);
                    if (isset($form)) {
                        $select[$this_module->name][$this_module->id . '-' . $form->id] = $form->name;
                    }
                }
            }
        }

        return $select;
    }
}
