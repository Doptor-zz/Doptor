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
use Input;
use Response;
use Str;
use View;
use Module;
use PDF;

class ReportBuilderController extends AdminController {

    /**
     * Display a listing of the form.
     * @return Response
     */
    public function index()
    {
        $modules = Module::all();

        $this->layout->title = 'Report Builder';
        $this->layout->content = View::make($this->link_type.'.'.$this->current_theme.'.report_builders.index')
                                        ->with('modules', $modules);
    }

    /**
     * Create the report
     * @return Response
     */
    public function postIndex()
    {
        $input = Input::all();

        if (isset($input['csv-report'])) {
            return $this->csvReport($input);
        } elseif (isset($input['pdf-report'])) {
            return $this->pdfReport($input);;
        } else {
            return $this->printHtml($input);
        }
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
        $fields = $config['fields'];
        $field_names = (isset($config['field_names'])) ? $config['field_names'] : $fields;

        $fieldAndNames = array_combine($fields, $field_names);

        $fieldAndNames['created_at'] = 'Created At';
        $fieldAndNames['updated_at'] = 'Updated At';

        return $fieldAndNames;
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

    /**
     * Get the entries based on the input
     * @param  array $input
     * @param  Collection $module
     * @return Collection
     */
    public function moduleEntries($input, $module)
    {
        $entries = DB::table("module_{$module->table}")
                        ->where(function($query) use ($input) {
                            if ($input['start_date'] != '') {
                                $query->where('created_at', '>', $input['start_date']);
                            }
                        })
                        ->where(function($query) use ($input) {
                            if ($input['start_date'] != '') {
                                $query->where('created_at', '<', $input['start_date']);
                            }
                        })
                        ->get();
        return $entries;
    }

    /**
     * Generate a CSV report
     * @param  array $input           Input
     * @return string
     */
    public function csvReport($input)
    {
        $module = Module::find($input['module_name']);

        $output = '';
        $output = fopen('php://output', 'w');

        $required_fields = $this->requiredFields($input);

        // Put the name of the fields in CSV
        fputcsv($output, $required_fields);

        $entries = $this->moduleEntries($input, $module);

        foreach ($entries as $entry) {
            $fields = array();
            foreach ($required_fields as $field => $name) {
                $fields[] = $entry->{$field};
            }
            fputcsv($output, $fields);
        }
        fclose($output);

        $csv = ob_get_clean();

        $filename = ($input['title']!='') ? Str::slug($input['title'], '_') : Str::slug($module->name, '_');
        $headers = array(
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'.csv"'
        );

        return Response::make(rtrim($csv, "\n"), 200, $headers);
    }

    /**
     * Generate a PDF report
     * @param  array $input    Input
     * @return string
     */
    public function pdfReport($input)
    {
        $module = Module::find($input['module_name']);
        $required_fields = $this->requiredFields($input);

        $entries = $this->moduleEntries($input, $module);

        $data = array(
                'title'           => $input['title'],
                'required_fields' => $required_fields,
                'entries'         => $entries,
                'isPdf'           => true
            );

        $filename = ($input['title']!='') ? Str::slug($input['title'], '_') : Str::slug($module->name, '_');

        $pdf = PDF::loadView('backend.'.$this->current_theme.'.report_builders.print', $data);
        return $pdf->download("{$filename}.pdf");
    }

    /**
     * Generate a HTML document for printing
     * @param  array $input Input
     * @return View
     */
    public function printHtml($input)
    {
        $module = Module::find($input['module_name']);
        $required_fields = $this->requiredFields($input);

        $entries = $this->moduleEntries($input, $module);

        return View::make($this->link_type.'.'.$this->current_theme.'.report_builders.print')
                        ->with('title', $input['title'])
                        ->with('required_fields', $required_fields)
                        ->with('entries', $entries)
                        ->with('isPdf', false);
    }
}
