<?php namespace Components\ReportBuilder\Controllers\Backend;
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
use Input;
use File;
use Redirect;
use Response;
use Str;
use View;
use Module;
use PDF;

use Backend\AdminController as BaseController;
use Components\ReportBuilder\Models\BuiltReport;

class ReportBuilderController extends BaseController {

    public function __construct()
    {
        parent::__construct();

        // Add location hinting for views
        View::addNamespace('report_builders',
            app_path() . "/views/{$this->link_type}/{$this->current_theme}/report_builders");
    }

    /**
     * Display a listing of the created report builders.
     */
    public function index()
    {
        $report_builders = BuiltReport::all();

        $this->layout->title = 'All Report Builders';
        $this->layout->content = View::make('report_builders::index')
            ->with('report_builders', $report_builders);
    }

    /**
     * Display a listing of the form.
     * @return Response
     */
    public function create()
    {
        $modules = Module::all();

        $this->layout->title = 'Create Report Builder';
        $this->layout->content = View::make('report_builders::create_edit')
                                        ->with('modules', $modules);
    }

    /**
     * Create the report
     * @return Response
     */
    public function store()
    {
        $input = Input::all();

        $input['required_fields'] = $this->requiredFields($input);

        $report_file = $this->getReportGenerator($input);

        BuiltReport::create($input);

        return Response::download($report_file);
    }

    public function edit($id)
    {
        $report_builder = BuiltReport::find($id);
        $modules = Module::all();

        $this->layout->title = 'Edit Report Builder';
        $this->layout->content = View::make('report_builders::create_edit')
                                        ->with('modules', $modules)
                                        ->with('report_builder', $report_builder);
    }

    public function update($id)
    {
        $input = Input::all();

        $report_builder = BuiltReport::findOrFail($id);

        $input['required_fields'] = $this->requiredFields($input);

        $report_file = $this->getReportGenerator($input);

        $report_builder->update($input);

        return Response::download($report_file);
    }

    public function destroy($id=null)
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

        foreach ($selected_ids as $id) {
            $post = BuiltReport::findOrFail($id);

            $post->delete();
        }

        $wasOrWere = (count($selected_ids) > 1) ? 's were' : ' was';
        $message = 'The report builder' . $wasOrWere . ' deleted.';

        return Redirect::to("backend/report-builder")
                                ->with('success_message', $message);
    }

    /**
     * Get all the fields that are available in a module
     * @param  integer $id Module ID
     * @return array     The fields in the module
     */
    public function getModuleFields($id)
    {
        $module = Module::find($id);

        $config = json_decode(file_get_contents(app_path() . '/modules/' . $module->alias  . '/module.json'), true);

        $fieldAndNames = array();
        foreach ($config['forms'] as $form) {
            $fields = array_combine($form['fields'], $form['field_names']);
            $fields['created_at'] = 'Created At';
            $fields['updated_at'] = 'Updated At';

            $form_info = array(
                    'name'   => $form['form_name'],
                    'model'  => $form['model'],
                    'fields' => $fields
                );

            $fieldAndNames[] = $form_info;
        }

        return Response::json($fieldAndNames);
    }

    /**
     * Get only the required fields from the input
     * @param  array $input Input
     * @return array
     */
    public function requiredFields($input)
    {
        $required_fields = array();
        foreach ($input as $key => $value) {
            // Get only the input, that are fields in the module
            if (str_contains($key, 'fields_')) {
                $key = str_replace('fields_', '', $key);
                $required_fields[$key] = $value;
            }
        }
        return $required_fields;
    }

    private function getReportGenerator($input)
    {
        $module = Module::findOrFail($input['module_id']);

        $output = array(
                'name'            => $input['name'],
                'author'          => $input['author'],
                'version'         => $input['version'],
                'website'         => $input['website'],
                'module_name'     => $module->name,
                'module_alias'    => $module->alias,
                'model'           => 'Modules\\'.$module->alias.'\Models\\' . $input['model_name'],
                'required_fields' => $input['required_fields'],
                'show_calendars'  => isset($input['show_calendars']) ? true : false
            );

        $report_alias = Str::slug($input['name'], '_');
        $report_file = temp_path() . "/report_{$report_alias}.json";
        file_put_contents($report_file, json_encode($output));

        return $report_file;
    }

    public function download($id)
    {
        $report = BuiltReport::findOrFail($id);

        $canonical = Str::slug($report->name, '_');
        $zip_file = File::exists($report->file);

        if (!$zip_file) {
            return Redirect::to($this->link_type . "/report-builder/{$id}/edit")
                ->with('error_message', 'The download file couldn\'t be found. Create and download the report file.');
        }

        return Response::download($zip_file, $canonical);
    }
}
