<?php namespace Components\ContactManager\Controllers\Backend;

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
use DB;
use Input;
use Redirect;
use Str;
use View;

use Components\ContactManager\Models\ContactCategory;
use Backend\AdminController as BaseController;
use Services\Validation\ValidationException as ValidationException;

class ContactController extends BaseController {

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
        $this->config = json_decode(file_get_contents(__DIR__ . '/../../module.json'), true);
        $this->forms = $this->config['forms'];
        $this->module_name = $this->config['info']['name'];
        $this->module_alias = $this->config['info']['alias'];
        $this->module_link = Str::snake($this->module_alias, '_');

        View::share('module_name', $this->module_name);
        View::share('module_alias', $this->module_alias);
        View::share('module_link', $this->module_link);

        parent::__construct();

        $this->type = $this->link_type;

        // Add location hinting for views
        View::addNamespace('contact_manager',
            app_path() . "/views/{$this->type}/{$this->current_theme}/contact_manager");
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        foreach ($this->forms as $i => $form) {
            $model_name = "Components\\ContactManager\\Models\\{$this->forms[$i]['model']}";

            if ($i == 0) {
                $this->forms[$i]['entries'] = $model_name::with('category')->get();

                // Donot show all fields in the index page
                $this->forms[$i]['fields'] = array_diff($this->forms[$i]['fields'], array('image', 'email', 'telephone', 'fax', 'email', 'location', 'city', 'state', 'zip_code'));
                $this->forms[$i]['field_names'] = array_diff($this->forms[$i]['fields'], array('Image', 'Email', 'Telephone', 'Fax', 'Email', 'Location', 'City', 'State', 'Zip_code'));
            } else {
                $this->forms[$i]['entries'] = $model_name::get();
            }

        }

        $this->layout->title = "All Entries in {$this->module_name}";
        $this->layout->content = View::make("contact_manager::index")
            ->with('title', "All Entries in {$this->module_name}")
            ->with('forms', $this->forms);
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
        $categories = ContactCategory::lists('name', 'id');

        $this->layout->title = "Add new in {$this->module_name}";;
        $this->layout->content = View::make("contact_manager::create_edit")
            ->with('title', "Add new in {$this->module_name}")
            ->with('form', $form)
            ->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store()
    {
        $input = Input::all();

        if (isset($input['form_close'])) {
            return Redirect::to("{$this->link}contact-manager");
        }

        if (isset($input['form_save'])) {
            $redirect = "{$this->link}contact-manager";
        } else {
            $redirect = "{$this->link}contact-manager/create/{$input['form_id']}";
        }

        $input['location'] = json_encode(array(
            'latitude'  => $input['location-lat'],
            'longitude' => $input['location-lon'],
        ));
        $display_options = $this->getDisplayOptions($input);

        $input['display_options'] = json_encode($display_options);

        $form = $this->getForm($input['form_id']);

        try {
            App::make('Components\\ContactManager\\Validation\\ContactValidator')->validateForCreation($input);

            $model_name = "Components\\ContactManager\\Models\\{$form['model']}";
            $entry = $model_name::create($input);

        } catch (ValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }

        if ($entry) {
            return Redirect::to($redirect)
                ->with('success_message', 'The contact has been successfully added.');
        } else {
            return Redirect::back()
                ->with('error_message', 'The contact couldn\'t be added.');
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

        $model_name = "Components\\ContactManager\\Models\\{$form['model']}";
        $contact = $model_name::findOrFail($id);

        $this->layout->title = "Showing Contact Details";
        $this->layout->content = View::make("contact_manager::show")
            ->with('title', "Showing Contact Details")
            ->with('contact', $contact)
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

        $model_name = "Components\\ContactManager\\Models\\{$form['model']}";
        $entry = $model_name::findOrFail($id);

        $categories = ContactCategory::lists('name', 'id');

        $entry->location = json_decode($entry->location, true);

        $this->layout->title = "Edit contact in {$this->module_name}";;

        $this->layout->content = View::make("contact_manager::create_edit")
            ->with('title', "Edit contact in module {$this->module_name}")
            ->with('entry', $entry)
            ->with('form', $form)
            ->with('categories', $categories);
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
            return Redirect::to("{$this->link}contact-manager");
        }

        if (isset($input['form_save'])) {
            $redirect = "{$this->link}contact-manager";
        } else {
            $redirect = "{$this->link}contact-manager/create/{$input['form_id']}";
        }

        $input['location'] = json_encode(array(
            'latitude'  => $input['location-lat'],
            'longitude' => $input['location-lon'],
        ));

        $display_options = $this->getDisplayOptions($input);

        $input['display_options'] = json_encode($display_options);

        $form = $this->getForm($input['form_id']);

        try {
            App::make('Components\\ContactManager\\Validation\\ContactValidator')->validateForCreation($input);

            $model_name = "Components\\ContactManager\\Models\\{$form['model']}";
            $entry = $model_name::find($id)->update($input);

        } catch (ValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }

        return Redirect::to($redirect)
            ->with('success_message', 'The contact has been successfully updated.');
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
                    ->with('error_message', "Nothing was selected to delete");
            }
            $selected_ids = explode(' ', $selected_ids);
        } else {
            $selected_ids = array($id);
        }

        $form = $this->getForm(Input::get('form_id'));
        $model_name = "Components\\ContactManager\\Models\\{$form['model']}";

        foreach ($selected_ids as $id) {
            $entry = $model_name::findOrFail($id);

            $entry->delete();
        }

        if (count($selected_ids) > 1) {
            $message = 'The entries were deleted';
        } else {
            $message = 'The contact was deleted';
        }

        return Redirect::back()
            ->with('success_message', $message);
    }

    /**
     * @param $form_id
     * @return array|mixed
     */
    protected function getForm($form_id)
    {
        $form = array_filter($this->forms, function ($form) use ($form_id) {
            if ($form['form_id'] == $form_id) return true;
        });
        $form = head($form);

        return $form;
    }

    /**
     * What fields to display to the public
     * @param $input
     * @return array
     */
    private function getDisplayOptions($input)
    {
        $keys = array_keys($input);

        $display_keys = array_filter($keys, function ($key) {
            return (str_contains($key, 'display_')) ? true : false;
        });

        $display_options = array();

        foreach ($display_keys as $key) {
            $name = str_replace('display_', '', $key);
            $display_options[$name] = (int)$input[$key];
        }

        return $display_options;
    }
}
