<?php namespace Modules\ModuleName\Controllers;
/*
=================================================
Module Name     :   NameOfTheModule
Module Version  :   vVersionOfTheModule
Compatible CMS  :   v1.2
Site            :   WebsiteOfTheModule
Description     :   DescriptionOfTheModule
===================================================
*/
use DB;
use Input;
use Redirect;
use Str;
use View;

use Backend\AdminController as BaseController;
use Services\Validation\ValidationException as ValidationException;

class BackendController extends BaseController {

    /**
     * The layout that should be used for responses.
     */
    protected $layout;
    // Type of the parent page
    protected $type;
    protected $config;
    protected $fields;
    protected $module_alias;
    protected $module_link;

    public function __construct()
    {
        $this->config = json_decode(file_get_contents(__DIR__ . '/../module.json'), true);
        $this->forms = $this->config['forms'];
        // $this->fields = $this->config['fields'];
        // $this->field_names = $this->config['field_names'];
        $this->module_name = $this->config['info']['name'];
        $this->module_alias = $this->config['info']['alias'];
        $this->module_vendor = $this->config['info']['vendor'];
        $this->module_link = Str::snake($this->module_alias, '_');

        if ($this->module_vendor) {
            $this->module_namespace = "Modules\\{$this->module_vendor}\\{$this->module_alias}\\";
        } else {
            $this->module_namespace = "Modules\\{$this->module_alias}\\";
        }

        View::share('module_name', $this->module_name);
        View::share('module_alias', $this->module_alias);
        View::share('module_vendor', $this->module_vendor);
        View::share('module_link', $this->module_link);

        parent::__construct();

        $this->type = $this->link_type;

        // Add location hinting for views
        View::addNamespace($this->module_alias,
            app_path() . "/Modules/{$this->module_vendor}/{$this->module_alias}/Views");
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $this->getFormEntries();

        $this->layout->title = "All Entries in {$this->module_name}";
        $this->layout->content = View::make("{$this->module_alias}::{$this->type}.index")
            ->with('title', "All Entries in {$this->module_name}")
            ->with('forms', $this->forms);
    }

    /**
     * Get the form entries for the fields that have to be shown
     */
    private function getFormEntries()
    {
        $vendor = Str::lower($this->module_vendor);
        $forms = $this->forms;

        foreach ($forms as $i => $form) {
            $form_fields = $form['fields'];

            foreach ($form_fields as $key => $form_field) {
                if (isset($form['fields_to_show']) &&
                    !in_array($form_field, $form['fields_to_show'])
                ) {
                    // Remove fields that are not to be shown
                    unset($forms[$i]['fields'][$key]);
                    unset($forms[$i]['field_names'][$key]);
                } else {
                    $forms[$i]['entries'] = DB::table('mdl_' . $vendor . '_' . $form['table'])->get();
                }
            }
        }

        $this->forms = $forms;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $form_id
     */
    public function create($form_id)
    {
        // Get only the form that matches the specified form id
        $form = $this->getForm($form_id);
        $sources = $this->getSources();

        $this->layout->title = "Add New Entry in {$this->module_name}";;
        $this->layout->content = View::make("{$this->module_alias}::{$this->type}.create_edit")
            ->with('title', "Add New Entry in {$this->module_name}")
            ->with('form', $form)
            ->with('sources', $sources);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store()
    {
        $input = Input::all();

        if (isset($input['form_close'])) {
            return Redirect::to("{$this->link}modules/{$this->module_link}");
        }

        if (isset($input['form_save'])) {
            $redirect = "{$this->link}modules/{$this->module_link}";
        } else {
            $redirect = "{$this->link}modules/{$this->module_link}/create/{$input['form_id']}";
        }

        $form = $this->getForm($input['form_id']);

        $model_name = $this->module_namespace . "Models\\{$form['model']}";

        try {
            $entry = $model_name::create($input);
        } catch (ValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }

        if ($entry) {
            return Redirect::to($redirect)
                ->with('success_message', trans('success_messages.entry_create'));
        } else {
            return Redirect::back()
                ->with('error_message', trans('error_messages.entry_create'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @param $form_id
     */
    public function show($id, $form_id)
    {
        // Get only the form that matches the specified form id
        $form = $this->getForm($form_id);

        $model_name = $this->module_namespace . "Models\\{$form['model']}";
        $entry = $model_name::findOrFail($id);

        $this->layout->title = "Showing Entry in {$this->module_name}";;
        $this->layout->content = View::make("{$this->module_alias}::{$this->type}.show")
            ->with('title', "Showing Entry in {$this->module_name}")
            ->with('entry', $entry)
            ->with('field_names', $form['field_names'])
            ->with('fields', $form['fields']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @param $form_id
     */
    public function edit($id, $form_id)
    {
        // Get only the form that matches the specified form id
        $form = $this->getForm($form_id);
        $sources = $this->getSources();

        $model_name = $this->module_namespace . "Models\\{$form['model']}";
        $entry = $model_name::findOrFail($id);

        $this->layout->title = "Edit Entry in {$this->module_name}";;

        $this->layout->content = View::make("{$this->module_alias}::{$this->type}.create_edit")
            ->with('title', "Edit Entry in module {$this->module_name}")
            ->with('entry', $entry)
            ->with('form', $form)
            ->with('sources', $sources);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        $input = Input::all();

        if (isset($input['form_close'])) {
            return Redirect::to("{$this->link}modules/{$this->module_link}");
        }

        if (isset($input['form_save'])) {
            $redirect = "{$this->link}modules/{$this->module_link}";
        } else {
            $redirect = "{$this->link}modules/{$this->module_link}/create/{$input['form_id']}";
        }

        $form = $this->getForm($input['form_id']);
        $model_name = $this->module_namespace . "Models\\{$form['model']}";

        try {
            $entry = $model_name::find($id)->update($input);
        } catch (ValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }

        if ($entry) {
            return Redirect::to($redirect)
                ->with('success_message', trans('success_messages.entry_update'));
        } else {
            return Redirect::back()
                ->with('error_message', trans('error_messages.entry_update'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id = null)
    {
        // If multiple ids are specified
        if ($id == 'multiple') {
            $selected_ids = trim(Input::get('selected_ids'));
            if ($selected_ids == '') {
                return Redirect::back()
                    ->with('error_message', trans('error_messages.nothing_selected_delete'));
            }
            $selected_ids = explode(' ', $selected_ids);
        } else {
            $selected_ids = array($id);
        }

        $form = $this->getForm(Input::get('form_id'));
        $model_name = $this->module_namespace . "Models\\{$form['model']}";

        foreach ($selected_ids as $id) {
            $entry = $model_name::findOrFail($id);

            $entry->delete();
        }

        if (count($selected_ids) > 1) {
            $message = trans('success_messages.entries_delete');
        } else {
            $message = trans('success_messages.entry_delete');
        }

        return Redirect::back()
            ->with('success_message', $message);
    }

    /**
     * @param $form_id
     * @return array|mixed
     */
    private function getForm($form_id)
    {
        $form = array_filter($this->forms, function ($form) use ($form_id) {
            if ($form['form_id'] == $form_id) return true;
        });
        $form = head($form);

        return $form;
    }

    /**
     * GEt sources for dropdown fields in forms
     * @return mixed
     */
    private function getSources()
    {
        $sources = ***SOURCES***;

        return $sources;
    }
}
