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
use Session;
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

        $input = $this->formatInput($input);

        $report_builder = BuiltReport::create($input);

        Session::put('download_file', $report_builder->id);
        return Redirect::to('backend/report-builder')
                        ->with('success_message', 'The report builder was created');
    }

    public function edit($id)
    {
        $report_builder = BuiltReport::findOrFail($id);

        $modules = Module::all();

        $module_ids = array();
        $required_fields = array();
        if ($report_builder->modules != 0) {
            foreach ($report_builder->modules as $selected_module) {
                $module_ids[] = $selected_module['id'];
                $required_fields[] = $selected_module['required_fields'];
            }
        }

        $module_ids = array_unique($module_ids);
        $required_fields = str_replace('\\', '', json_encode($required_fields));

        $this->layout->title = 'Edit Report Builder';
        $this->layout->content = View::make('report_builders::create_edit')
                                        ->with('report_builder', $report_builder)
                                        ->with('modules', $modules)
                                        ->with('required_fields', $required_fields)
                                        ->with('module_ids', $module_ids);
    }

    public function update($id)
    {
        $input = Input::all();

        $report_builder = BuiltReport::findOrFail($id);

        $input = $this->formatInput($input);

        $report_builder->update($input);

        Session::put('download_file', $id);
        return Redirect::to('backend/report-builder')
                        ->with('success_message', 'The report builder was updated');
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
     * @param  integer $i
     * @return array
     */
    public function requiredFields($input, $i)
    {
        $required_fields = array();
        foreach ($input as $key => $value) {
            // Get only the input, that are fields in the module
            if (str_contains($key, 'fields-'.$i.'_')) {
                $key = str_replace('fields-'.$i.'_', '', $key);
                $required_fields[$key] = $value;
            }
        }
        return $required_fields;
    }

    public function formatInput($input)
    {
        $count = $input['count-value'];
        $modules = array();

        for ($i=1; $i<=$count; $i++) {
            if (!isset($input['module_id-'.$i])) {
                continue;
            }
            $module_id = $input['module_id-'.$i];
            $model_name = $input['model_name-'.$i];
            $form_name = $input['form_name-'.$i];
            $module = Module::find($module_id);
            $required_fields = $this->requiredFields($input, $i);

            if ($module && !empty($required_fields)) {
                $modules[] = array(
                            'id'              => $module_id,
                            'name'            => $module->name,
                            'alias'           => $module->alias,
                            'form_name'       => $form_name,
                            'model'           => 'Modules\\'.$module->alias.'\Models\\' . $model_name,
                            'required_fields' => $required_fields
                        );
            }
        }

        $output = array(
                'name'           => $input['name'],
                'author'         => $input['author'],
                'version'        => $input['version'],
                'website'        => $input['website'],
                'modules'        => $modules,
                'show_calendars' => isset($input['show_calendars']) ? true : false
            );

        return $output;
    }

    /**
     * Create the report generator for download
     * @param  $input
     * @return
     */
    private function getReportGenerator($input)
    {
        if (isset($input['id'])) unset($input['id']);
        if (isset($input['created_by'])) unset($input['created_by']);
        if (isset($input['updated_by'])) unset($input['updated_by']);
        if (isset($input['created_at'])) unset($input['created_at']);
        if (isset($input['updated_at'])) unset($input['updated_at']);

        $report_alias = Str::slug($input['name'], '_');
        $report_file = temp_path() . "/report_generator.json";
        file_put_contents($report_file, json_encode($input));

        $zip_file = temp_path() . "/report_{$report_alias}.zip";
        Zip(temp_path() . "/report_generator.json", $zip_file, false);

        return $zip_file;
    }

    /**
     * Download the report builder
     * @param $id
     * @return
     */
    public function download($id)
    {
        Session::forget('download_file');
        $report = BuiltReport::findOrFail($id);

        $zip_file = $this->getReportGenerator($report->toArray());

        return Response::download($zip_file);
    }
}
