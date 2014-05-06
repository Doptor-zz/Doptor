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
use Input, View;
use Module;

class ReportBuilderController extends AdminController {

    /**
     * Display a listing of the form.
     * @return Response
     */
    public function index()
    {
        $modules = Module::all();

        $this->layout->title = 'Report Builder';
        $this->layout->content = View::make('backend.'.$this->current_theme.'.report_builders.index')
                                        ->with('modules', $modules);
    }

    public function postIndex()
    {
        $input = Input::all();
        // dd($input);
        $module = Module::find($input['module_name']);

        $module_fields = array();
        foreach ($input as $key => $value) {
            if (str_contains($key, 'fields_')) {
                $key = str_replace('fields_', '', $key);
                $module_fields[$key] = $value;
            }
        }
        // dd($module_fields);
        $entries = \DB::table("module_{$module->table}")->get();

        $output = '';
        $output = fopen('php://output', 'w');
        foreach ($entries as $entry) {
            // dd($entry->name23123);
            $fields = array();
            foreach ($module_fields as $field => $name) {
                // dd($entry->{$field});
                $fields[] = $entry->{$field};
            }
            fputcsv($output, $fields);
        }
        fclose($output);
        $csv = ob_get_clean();
        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="ExportFileName.csv"',
        );

        return \Response::make(rtrim($csv, "\n"), 200, $headers);
    }

    public function getModuleFields($id)
    {
        $module = Module::find($id);

        $config = json_decode(file_get_contents(app_path() . '/modules/' . $module->alias  . '/module.json'), true);
        $fields = $config['fields'];
        $field_names = (isset($config['field_names'])) ? $config['field_names'] : $fields;

        return array_combine($fields, $field_names);
    }

}
