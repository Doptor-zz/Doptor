<?php namespace Services;

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
use Exception;
use File;
use Str;

use BuiltForm;
use BuiltModule;
use FormCategory;

class ModuleBuilder {

    public $templatePath;

    public $selected_forms;

    protected $module_name;

    protected $form_rendered;

    protected $nav_tabs;

    protected $temp_dir;

    function __construct()
    {
        $this->templatePath = app_path() . '/services/module_template/';
        $this->selected_forms = array();
        $this->form_rendered = '';
        $this->nav_tabs = '';
    }

    public function createModule($input)
    {
        $this->generateHashForNullHashModules();

        $this->module_name = $input['name'];

        $module_alias = $this->generateModuleAlias($this->module_name);

        $this->temp_dir = temp_path() . "/{$module_alias}/{$module_alias}";

        $this->getSelectedForms($input);

        // Copy the template to temporary folder
        $this->copyTemplate();

        // Generate the inner portion of the form
        $this->generateInnerForm();

        // Adjust the template files, based on the input
        $this->adjustFiles($input);

        // Save the module configuration as json
        $this->saveModuleConfig($input, $module_alias);

        // Finally compress the temporary folder
        $zip_file = $this->generateZip($module_alias);

        return $zip_file;
    }

    private function generateHashForNullHashModules()
    {
        $null_hash_modules = BuiltModule::whereNull('hash')->get();

        foreach ($null_hash_modules as $null_hash_module) {
            $null_hash_module->hash = uniqid('module_');
            $null_hash_module->save();
        }
    }

    /**
     * Generate the alias of the module
     * @param $module_name
     * @return mixed
     */
    private function generateModuleAlias($module_name)
    {
        $module_alias = str_replace(' ', '', Str::title($module_name));

        return $module_alias;
    }

    /**
     * Get all the forms that were selected
     * @param $input
     */
    private function getSelectedForms($input)
    {
        $count = 0;

        for ($i = 1; $i <= $input['form-count']; $i++) {
            if (isset($input["form-{$i}"])) {
                if ($input["form-{$i}"] != 0) {
                    $this->selected_forms[$count]['form_id'] = $input["form-{$i}"];
                }
                $count++;
            }
        }
    }

    /**
     * Copy the module template to a temporary directory
     */
    private function copyTemplate()
    {
        if (!File::exists($this->templatePath)) {
            throw new Exception('The module template directory "' . $this->templatePath . '" doesn\'t exist.');
        }

        File::exists($this->temp_dir) && File::delete($this->temp_dir);

        File::copyDirectory($this->templatePath, $this->temp_dir);
    }

    /**
     * Save the module configuration to a json file
     * @param $input
     * @param $module_alias
     */
    private function saveModuleConfig($input, $module_alias)
    {
        $module_config = array(
            'enabled' => true,
            'info'    => array(
                'name'        => $this->module_name,
                'hash'        => $input['hash'],
                'alias'       => $module_alias,
                'version'     => $input['version'],
                'author'      => $input['author'],
                'website'     => $input['website'],
                'description' => $input['description'],
            ),
            // 'provider'    => 'App\Modules\\' . $module_title_case . '\\ServiceProvider',
            'target'  => implode('|', $input['target']),
            'forms'   => $this->selected_forms
        );

        // Create the config file for module
        file_put_contents(temp_path() . "/{$module_alias}/module.json", json_encode($module_config));
    }

    /**
     * Generate the inner portion form based on the input
     */
    private function generateInnerForm()
    {
        foreach ($this->selected_forms as $index => $selected_form) {
            $form = BuiltForm::find($selected_form['form_id']);
            if (!$form) continue;

            // Get the information about the form
            $this->getFormInfo($index);

            // Get the available fields from the form data
            $form_fields = $this->getFormFields($form->data);

            if (!isset($form_fields['fields'])) {
                // If the form has no fields, no need of this form
                unset($this->selected_forms[$index]);
            } else {
                $this->selected_forms[$index]['fields'] = $form_fields['fields'];
                $this->selected_forms[$index]['field_names'] = $form_fields['field_names'];
            }

            $view = $this->generateForm($form);

            file_put_contents("{$this->temp_dir}/Views/form_{$form->id}.blade.php", $view);
        }

        $this->form = $form;
    }

    /**
     * Get the available form fields from the generated form
     * @param $form_data
     * @return array
     */
    public function getFormFields($form_data)
    {
        $form_json = json_decode(str_replace('\\', '', $form_data), true);
        $form_fields = array();

        for ($i = 1; $i < sizeof($form_json); $i++) {
            $this_form = $form_json[$i];
            if (!isset($this_form['fields']['id']) &&
                !isset($this_form['fields']['radios'])
            ) {
                continue;
            }

            if (isset($this_form['fields']['id'])) {
                $type = $this_form['fields']['id']['type'];
                $value = $this_form['fields']['id']['value'];
                $field_name = $this_form['fields']['label']['value'];
            } else {
                $type = 'radio';
                $value = $this_form['fields']['name']['value'];
                $field_name = $this_form['fields']['label']['value'];
            }

            if (in_array($type, array('text', 'input', 'textarea', 'radio', 'select')) &&
                !isset($this_form['fields']['buttontype'])
            ) {
                $form_fields['fields'][] = $value;
                $form_fields['field_names'][] = $field_name;
            }
        }

        return $form_fields;
    }

    /**
     * Get the information about the form
     * @param $index
     */
    private function getFormInfo($index)
    {
        $null_hash_forms = BuiltForm::whereNull('hash')->get();

        foreach ($null_hash_forms as $null_hash_form) {
            $null_hash_form->hash = uniqid('form_');
            $null_hash_form->save();
        }

        $form_id = $this->selected_forms[$index]['form_id'];
        $form = BuiltForm::find($form_id);

        $form_category = FormCategory::find($form->category)->name;

        $this->selected_forms[$index]['form_name'] = $form->name;
        $this->selected_forms[$index]['hash'] = $form->hash;
        $this->selected_forms[$index]['category'] = $form_category;
        $this->selected_forms[$index]['description'] = $form->description;
        $this->selected_forms[$index]['show_captcha'] = (boolean) $form->show_captcha;
        $this->selected_forms[$index]['data'] = $form->data;
        $this->selected_forms[$index]['rendered'] = $form->rendered;
        $this->selected_forms[$index]['extra_code'] = $form->extra_code;
        $this->selected_forms[$index]['redirect_to'] = $form->redirect_to;
        $this->selected_forms[$index]['email'] = $form->email;

        $table_name = $this->generateTableName($this->module_name, $form->name);

        $this->selected_forms[$index]['table'] = $table_name;
    }

    /**
     * Generate table name, for the selected module and form
     * @param $module_name
     * @param $form_name
     * @return string
     */
    private function generateTableName($module_name, $form_name)
    {
        $table_name = Str::limit(Str::slug($module_name, '_'), 7, '_') .
            Str::limit(Str::slug($form_name, '_'), 10, '');

        return $table_name;
    }

    /**
     * Generate the complete form
     * @param $form
     * @return string
     */
    public function generateForm($form)
    {
        $form_id = $form->id;
        $form_rendered = $form->rendered;
        $extra_code = $form->extra_code;

        $form_rendered = str_replace("/\n/", '', $form_rendered);
        $form_rendered = str_replace("//", '', $form_rendered);

        $view = '<?php $link_type = ($link_type=="public") ? "" : $link_type . "." ?>' . "\n";
        $view .= '@if (!isset($entry))' . "\n";
        $view .= '{{ Form::open(array("route"=>"{$link_type}modules.".$module_link.".store", "method"=>"POST", "class"=>"form-horizontal", "files"=>true)) }}' . "\n";
        $view .= '@else' . "\n";
        $view .= '{{ Form::open(array("route" => array("{$link_type}modules.".$module_link.".update", $entry->id), "method"=>"PUT", "class"=>"form-horizontal", "files"=>true)) }}' . "\n";
        $view .= '@endif' . "\n";

        $view .= '@if ($errors->has()) <div class="alert alert-error hide" style="display: block;"> <button data-dismiss="alert" class="close">×</button> You have some form errors. Please check below. </div> @endif';

        $view .= "{{ Form::hidden('form_id', {$form_id}) }} \n";

        $form_data = str_replace('<form class="form-horizontal">', '', urldecode($form_rendered));
        $view .= str_replace('</form>', '', $form_data);
        $view .= $extra_code . "\n";

        // Add save buttons
        $view .= '<div class="form-actions">' . "\n";
        $view .= '<button type="submit" class="btn btn-primary" name="form_save">Save</button>' . "\n";
        $view .= '<button type="submit" class="btn btn-success" name="form_save_new">Save &amp;  New</button>' . "\n";
        $view .= '<button type="submit" class="btn btn-primary btn-danger" name="form_close">Close</button>' . "\n";
        $view .= '</div>' . "\n";

        $view .= '{{ Form::close() }}';

        $captcha = $this->getCaptchaField($form);
        if ($captcha != '') {
            $view = str_replace('</fieldset>', $captcha . "\n</fieldset>", $view);
        }

        return $view;
    }

    /**
     * Get captcha to add to form if captcha option is selected
     * @param int $form
     */
    public function getCaptchaField($form)
    {
        $captcha = '';
        if ($form->show_captcha) {
            $captcha = '<div class="control-group {{{ $errors->has("captcha") ? "error" : "" }}}"> <label class="control-label">Enter captcha</label> <div class="controls"> {{ HTML::image(Captcha::img(), "Captcha image") }} {{ Form::text("captcha", "", array("required", "class"=>"input-medium")) }} {{ $errors->first("captcha", "<span class=\'help-inline\'>:message</span>") }}</div> </div>';
        }

        return $captcha;
    }

    /**
     * @param array $targets
     * @internal param $input
     * @return string
     */
    private function generateRoutes(array $targets)
    {
        $routes = '';
        foreach ($targets as $target) {
            $target = ($target == 'public') ? '' : $target;
            $routes .= "Route::resource('{$target}/modules/'.\$current_dir,
                'Modules\ModuleName\Controllers\BackendController');\n";
            // Route for create
            $routes .= "Route::get('{$target}/modules/'.\$current_dir.'/create/{form_id}',
                array(
                    'uses' => 'Modules\ModuleName\Controllers\BackendController@create',
                    'as' => '{$target}.modules.'.\$current_module.'.create'
                )
            );\n";
            // Route for show
            $routes .= "Route::get('{$target}/modules/'.\$current_dir.'/{id}/{form_id}',
                array(
                    'uses' => 'Modules\ModuleName\Controllers\BackendController@show',
                    'as' => '{$target}.modules.'.\$current_module.'.show'
                )
            );\n";
            // Route for edit
            $routes .= "Route::get('{$target}/modules/'.\$current_dir.'/{id}/edit/{form_id}',
                array(
                    'uses' => 'Modules\ModuleName\Controllers\BackendController@edit',
                    'as' => '{$target}.modules.'.\$current_module.'.edit'
                )
            );\n";
        }

        return $routes;
    }

    /**
     * Adjust the template files according to the provided input
     * @param $input
     */
    private function adjustFiles($input)
    {
        $module_title_case = str_replace(' ', '', Str::title($this->module_name));

        $this->SearchandReplace($this->temp_dir, 'NameOfTheModule', $this->module_name);
        $this->SearchandReplace($this->temp_dir, 'VersionOfTheModule', $input['version']);
        $this->SearchandReplace($this->temp_dir, 'WebsiteOfTheModule', $input['website']);
        $this->SearchandReplace($this->temp_dir, 'DescriptionOfTheModule', $input['description']);

        // Generate the required routes
        $routes = $this->generateRoutes($input['target']);
        $this->SearchandReplace($this->temp_dir, '***ROUTES***', $routes);

        if ($this->form->redirect_to == 'list') {
            $redirect_to = 'to($this->link . "modules/" . $this->module_name)';
        } elseif ($this->form->redirect_to == 'add') {
            $redirect_to = 'to($this->link . "modules/" . $this->module_name . "/create")';
        } else {
            $redirect_to = 'back()';
        }
        $this->SearchandReplace($this->temp_dir, '***REDIRECT_TO***', $redirect_to);

        $this->SearchandReplace($this->temp_dir, '***SOURCES***', $this->setFormDropdownSources($input));

        $this->SearchandReplace($this->temp_dir, 'CreateEntriesTable', 'Create' . $module_title_case . 'Table');

        $this->SearchandReplace($this->temp_dir, 'ModuleName', $module_title_case);

        $this->generateModules();
    }

    /**
     * Generate modules for each form tables
     */
    private function generateModules()
    {
        $model_template = $this->temp_dir . '/Models/ModuleModel.php';

        foreach ($this->selected_forms as $index => $selected_form) {
            $model_name = $this->generateModelName($selected_form['table']);

            $this->selected_forms[$index]['model'] = $model_name;

            $new_model = $this->temp_dir . '/Models/' . $model_name . '.php';

            File::copy($model_template, $new_model);

            $replace = array(
                'ModuleModel'  => $model_name,
                'table_name'   => 'mdl_' . $selected_form['table'],
                'table_fields' => "'" . implode("', '", $selected_form['fields']) . "'"
            );

            // Replace the template contents with actual data
            $model_contents = file_get_contents($new_model);
            $model_contents = strtr($model_contents, $replace);
            file_put_contents($new_model, $model_contents);
        }

        File::delete($this->temp_dir . '/Models/ModuleModel.php');
    }

    /**
     * Generate model name from the table name specified
     * @param $table_name
     * @return mixed
     */
    private function generateModelName($table_name)
    {
        $model_name = str_replace('_', '', Str::title($table_name));

        return $model_name;
    }

    /**
     * Generate a zip file of the module
     * @param $module_alias
     * @return string
     */
    private function generateZip($module_alias)
    {
        $zip_file = temp_path() . "/{$module_alias}.zip";
        $this->Zip(temp_path() . "/{$module_alias}/", $zip_file, false);
        File::deleteDirectory(temp_path() . "/{$module_alias}/");

        return $zip_file;
    }

    /**
     * Compresses a folder
     * @param $source
     * @param $destination
     * @param bool $include_dir
     * @return bool
     */
    public function Zip($source, $destination, $include_dir = true)
    {
        if (!extension_loaded('zip') || !file_exists($source)) {
            return false;
        }

        if (file_exists($destination)) {
            unlink($destination);
        }

        $zip = new \ZipArchive();
        if (!$zip->open($destination, \ZIPARCHIVE::CREATE)) {
            return false;
        }

        $source = str_replace('\\', '/', realpath($source));
        if (is_dir($source) === true) {
            $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($source), \RecursiveIteratorIterator::SELF_FIRST);

            if ($include_dir) {
                $arr = explode("/", $source);
                $maindir = $arr[count($arr) - 1];

                $source = "";
                for ($i = 0; $i < count($arr) - 1; $i++) {
                    $source .= '/' . $arr[$i];
                }

                $source = substr($source, 1);

                $zip->addEmptyDir($maindir);
            }

            foreach ($files as $file) {
                // Ignore "." and ".." folders
                if (in_array(substr($file, strrpos($file, DIRECTORY_SEPARATOR) + 1), array('.', '..', ':')))
                    continue;

                $file = realpath($file);
                // var_dump($file);
                $file = str_replace('\\', '/', $file);

                if (is_dir($file) === true) {
                    $dir = str_replace($source . '/', '', $file . '/');
                    $zip->addEmptyDir($dir);
                } else if (is_file($file) === true) {
                    $new_file = str_replace($source . '/', '', $file);
                    $zip->addFromString($new_file, file_get_contents($file));
                }
            }
        } else if (is_file($source) === true) {
            $zip->addFromString(basename($source), file_get_contents($source));
        }

        return $zip->close();
    }

    /**
     * Recursively replace all occurences of string within a directory
     * @param string $dir Source Directory
     * @param string $stringsearch String to search
     * @param string $stringreplace String to replace
     * @return array
     */
    public function SearchandReplace($dir, $stringsearch, $stringreplace)
    {
        $listDir = array();
        if ($handler = opendir($dir)) {
            while (($sub = readdir($handler)) !== false) {
                if ($sub != "." && $sub != ".." && $sub != "Thumb.db") {
                    if (is_file($dir . "/" . $sub)) {
                        if (substr_count($sub, '.php')) {
                            $getfilecontents = file_get_contents($dir . "/" . $sub);
                            if (substr_count($getfilecontents, $stringsearch) > 0) {
                                $replacer = str_replace($stringsearch, $stringreplace, $getfilecontents);
                                // Let's make sure the file exists and is writable first.
                                if (is_writable($dir . "/" . $sub)) {
                                    if (!$handle = fopen($dir . "/" . $sub, 'w')) {
                                        // echo "Cannot open file (".$dir."/".$sub.")";
                                        exit;
                                    }
                                    // Write $somecontent to our opened file.
                                    if (fwrite($handle, $replacer) === false) {
                                        // echo "Cannot write to file (".$dir."/".$sub.")";
                                        exit;
                                    }
                                    // echo "Success, removed searched content from:".$dir."/".$sub."";
                                    fclose($handle);
                                } else {
                                    // echo "The file ".$dir."/".$sub." is not writable ";
                                }
                            }
                        }
                        $listDir[] = $sub;
                    } elseif (is_dir($dir . "/" . $sub)) {
                        $listDir[$sub] = $this->SearchandReplace($dir . "/" . $sub, $stringsearch, $stringreplace);
                    }
                }
            }
            closedir($handler);
        }

        return $listDir;
    }

    /**
     * Get all the select/dropdown fields in a form
     * @param $form_id
     * @return array
     */
    public function getFormSelects($form_id)
    {
        $form = BuiltForm::find($form_id);

        $form_json = json_decode(str_replace('\\', '', $form->data), true);

        $form_selects = array();

        for ($i = 1; $i < sizeof($form_json); $i++) {
            $this_form = $form_json[$i];
            if (!isset($this_form['fields']['id']) &&
                !isset($this_form['fields']['radios'])
            ) {
                continue;
            }

            if (isset($this_form['fields']['id']) &&
                isset($this_form['fields']['options'])
            ) {
                $fields = $this_form['fields']['id']['value'];
                $field_name = $this_form['fields']['label']['value'];

                $form_selects[$fields] = $field_name;
            }
        }

        return $form_selects;
    }

    /**
     * @param $input
     * @return string
     */
    public function setFormDropdownSources($input)
    {
        $sources = array();
        $source_modules = array_filter(array_keys($input), function ($key) {
            if (str_contains($key, 'moduleform')) {
                return true;
            }
        });

        foreach ($source_modules as $source_module) {
            if ($input[$source_module] != 0) {
                list($module_id, $form_id) = explode('-', $input[$source_module]);

                // The form field of the current module, to be replaced by
                $form_field = str_replace('moduleform-', 'formfield-', $source_module);
                $field_name = str_replace('moduleform-', '', $source_module);

                $target_field = $input[$form_field];
                $module = BuiltModule::find($module_id);
                $form = BuiltForm::find($form_id);

                $module_alias = $this->generateModuleAlias($module->name);
                $table_name = $this->generateTableName($module->name, $form->name);
                $model_name = $this->generateModelName($table_name);

                $sources[$field_name] = "\\Modules\\{$module_alias}\\Models\\{$model_name}::lists('{$target_field}', '{$target_field}')";
            }
        }

        $source_array = var_export($sources, true);

        // Replace the sources to not be strings
        $source_array = strtr($source_array, array(
                            "=> '"   => "=> ",
                            "\\'"    => "'",
                            ")'"     => ")",
                            "\\\\"   => "\\"
                        ));

        return $source_array;
    }
}
