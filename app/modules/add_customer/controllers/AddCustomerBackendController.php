<?php

use Backend\AdminController as BaseController;

class AddCustomerBackendController extends BaseController {

    /**
     * The layout that should be used for responses.
     */
    protected $layout;
    // Type of the parent page
    protected $type;
    protected $config;
    protected $fields;
    protected $module_name;

    public function __construct()
    {
        $this->config = json_decode(file_get_contents(__DIR__ . '/../module.json'), true);
        $this->fields = $this->config['fields'];
        $this->module_name = $this->config['info']['canonical'];

        parent::__construct();

        $this->type = $this->link_type;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $entries = ModuleAddCustomer::all();

        $this->layout->title = "All Entries in {$this->config['info']['name']}";
        $this->layout->content = View::make("{$this->config['info']['canonical']}::{$this->type}.index")
                                        ->with('title', "All Entries in {$this->config['info']['name']}")
                                        ->with('entries', $entries)
                                        ->with('fields', $this->fields)
                                        ->with('module_name', $this->module_name);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->layout->title = "Add New Entry in {$this->config['info']['name']}";;
        $this->layout->content = View::make("{$this->config['info']['canonical']}::{$this->type}.create_edit")
                                        ->with('title', "Add New Entry in {$this->config['info']['name']}")
                                        ->with('module_name', $this->module_name);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();

        ModuleAddCustomer::create($input);

        return Redirect::to($this->link . "modules/" . $this->module_name)
                        ->with('success_message', 'The entry has been successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return View::make('backends.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $entry = ModuleAddCustomer::find($id);
        $this->layout->title = "Edit Entry in {$this->config['info']['name']}";;

        $this->layout->content = View::make("{$this->module_name}::{$this->type}.create_edit")
                                        ->with('title', "Add New Entry in {$this->config['info']['name']}")
                                        ->with('module_name', $this->module_name)
                                        ->with('entry', $entry)
                                        ->with('fields', $this->fields);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $input = Input::all();

        $entry = ModuleAddCustomer::find($id);
        $entry->update($input);

        return Redirect::to($this->link . "modules/" . $this->module_name)
                        ->with('success_message', 'The entry has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $entry = ModuleAddCustomer::find($id);

        if (isset($entry) && $entry->delete()) {
            return Redirect::back()
                            ->with('success_message', 'The entry was deleted.');
        } else {
            return Redirect::back()
                            ->with('success_message', 'The entry wasn\'t deleted.');
        }
    }

}
