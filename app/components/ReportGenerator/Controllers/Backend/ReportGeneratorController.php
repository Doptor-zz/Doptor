<?php namespace Components\ReportGenerator\Controllers\Backend;
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
use Redirect;
use Response;
use Str;
use View;
use Module;
use PDF;

use Components\ReportGenerator\Models\ReportGenerator;

use Backend\AdminController as BaseController;

class ReportGeneratorController extends BaseController {

    public function __construct()
    {
        parent::__construct();

        // Add location hinting for views
        View::addNamespace('report_generators',
            app_path() . "/views/{$this->link_type}/{$this->current_theme}/report_generators");
    }

    /**
     * Display a listing of the installed report generators.
     */
    public function index()
    {
        $report_generators = ReportGenerator::all();

        $this->layout->title = 'All Report Generators';
        $this->layout->content = View::make('report_generators::index')
            ->with('report_generators', $report_generators);
    }

    /**
     * Display a listing of the form.
     * @return Response
     */
    public function create()
    {
        $this->layout->title = 'Install Report Generator';
        $this->layout->content = View::make('report_generators::create_edit');
    }

    /**
     * Create the report
     * @return Response
     */
    public function store()
    {
        $input = Input::all();

        $file = Input::file('file');
        $filename = $file->getClientOriginalName();
        $file->move(temp_path(), $filename);

        $filename = str_replace('.ZIP', '.zip', $filename);
        $unzipSuccess = Unzip(temp_path() . "/{$filename}", temp_path());

        $contents = file_get_contents(temp_path() . "/report_generator.json");
        $report_info = json_decode($contents, true);
        $input = array(
                    'name'           => $report_info['name'],
                    'author'         => $report_info['author'],
                    'version'        => $report_info['version'],
                    'website'        => $report_info['website'],
                    'modules'        => json_encode($report_info['modules']),
                    'show_calendars' => $report_info['show_calendars']
                );

        if ($report_generator = ReportGenerator::where('name', '=', $input['name'])->first()) {
            $report_generator->update($input);
        } else {
            $report_generator = ReportGenerator::create($input);
        }

        return Redirect::to("{$this->link_type}/report-generators")
                        ->with('success_message', 'The report generator was installed');
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
            $post = ReportGenerator::findOrFail($id);

            $post->delete();
        }

        $wasOrWere = (count($selected_ids) > 1) ? 's were' : ' was';
        $message = 'The report generator' . $wasOrWere . ' deleted.';

        return Redirect::to("backend/report-generator")
                                ->with('success_message', $message);
    }

    public function getGenerate($id)
    {
        $generator = ReportGenerator::findOrFail($id);

        $this->layout->title = 'Generate report';
        $this->layout->content = View::make("{$this->link_type}.{$this->current_theme}.report_generators.generate")
                                ->with('generator', $generator);
    }

    public function postGenerate($id)
    {
        $input = Input::all();
        $input['start_date'] = isset($input['start_date']) ? $input['start_date'] : '';
        $input['end_date'] = isset($input['end_date']) ? $input['end_date'] : '';

        $generator = ReportGenerator::findOrFail($id);

        if (isset($input['csv-report'])) {
            return $this->csvReport($input, $generator);
        } elseif (isset($input['pdf-report'])) {
            return $this->pdfReport($input, $generator);
        } else {
            return $this->printHtml($input, $generator);
        }
    }

    /**
     * Get the entries based on the input
     * @param  array $input
     * @param  Collection $module
     * @return Collection
     */
    private function moduleEntries($input, $module)
    {
        $model = $module['model'];
        $entries = $model::where(function($query) use ($input) {
                            if ($input['start_date'] != '') {
                                $query->where('created_at', '>', $input['start_date']);
                            }
                        })
                        ->where(function($query) use ($input) {
                            if ($input['end_date'] != '') {
                                $query->where('created_at', '<', $input['end_date']);
                            }
                        })
                        ->orderBy('created_at', 'ASC')
                        ->get();
        return $entries;
    }

    /**
     * Generate a CSV report
     * @param  array $input           Input
     * @return string
     */
    private function csvReport($input, $generator)
    {
        $module = Module::find($generator->module_name);

        $output = '';
        $output = fopen('php://output', 'w');

        fputcsv($output, array(get_setting('company_name')));
        fputcsv($output, array($generator->name));

        $date_info = '';
        if ($input['start_date'] != '') {
            $input['start_date'] = preg_replace('/ \d+:.*$/', '', $input['start_date']);
            $date_info .= "From: {$input['start_date']}";
        }
        if ($input['end_date'] != '') {
            $input['end_date'] = preg_replace('/ \d+:.*$/', '', $input['end_date']);
            $date_info .= " To: {$input['end_date']}";
        }

        fputcsv($output, array($date_info));

        $modules = $this->getModules($generator->modules, $input);

        foreach ($modules as $i => $module) {
            // Put the name of the fields in CSV
            fputcsv($output, $module['required_fields']);

            foreach ($module['entries'] as $entry) {
                $fields = array();
                foreach ($module['required_fields'] as $field => $name) {
                    $fields[] = $entry->{$field};
                }
                fputcsv($output, $fields);
            }
        }

        $footer = 'Printed by: '.current_user()->username.' on '. date('Y-m-d h:m:i');
        fputcsv($output, array($footer));

        fclose($output);
        $csv = ob_get_clean();

        $filename = ($generator->name!='') ? Str::slug($generator->name, '_') : Str::slug($module->name, '_');
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
    private function pdfReport($input, $generator)
    {
        $modules = $this->getModules($generator->modules, $input);

        $input['start_date'] = preg_replace('/ \d+:.*$/', '', $input['start_date']);
        $input['end_date'] = preg_replace('/ \d+:.*$/', '', $input['end_date']);

        $data = array(
                'title'   => $generator->name,
                'modules' => $modules,
                'input'   => $input,
                'isPdf'   => false
            );

        $filename = ($generator->name!='') ? Str::slug($generator->name, '_') : Str::slug($module->name, '_');

        $pdf = PDF::loadView('report_generators::print', $data);
        return $pdf->download("{$filename}.pdf");
    }

    /**
     * Generate a HTML document for printing
     * @param  array $input Input
     * @return View
     */
    private function printHtml($input, $generator)
    {
        $modules = $this->getModules($generator->modules, $input);

        $input['start_date'] = preg_replace('/ \d+:.*$/', '', $input['start_date']);
        $input['end_date'] = preg_replace('/ \d+:.*$/', '', $input['end_date']);

        $data = array(
                'title'   => $generator->name,
                'modules' => $modules,
                'input'   => $input,
                'isPdf'   => false
            );

        return View::make('report_generators::print', $data);
    }

    /**
     * Get modules along with data
     * @param  object $modules
     * @param  array $input
     * @return object
     */
    public function getModules($modules, $input)
    {
        $modules = json_decode($modules, true);

        if ($modules) {
            foreach ($modules as $i => $module) {
                $modules[$i]['entries'] = $this->moduleEntries($input, $module);
            }
        } else {
            $modules = array();
        }
        return $modules;
    }
}
