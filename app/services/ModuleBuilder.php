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
use App;
use BuiltForm;
use Exception;
use File;
use Redirect;
use Response;
use Str;
use View;

class ModuleBuilder {

    function __construct()
    {
        $this->templatePath = app_path() . '/services/module_template/';
        $this->fields = array();
        $this->field_names = array();
        $this->form_rendered = '';
        $this->nav_tabs = '';
    }

    public function createModule($input)
    {
        $module_alias = str_replace(' ', '', Str::title($input['name']));

        $input['table_name'] = ($input['table_name'] == '') ? $module_alias : $input['table_name'];
        $temp_dir = temp_path() . "/{$module_alias}/{$module_alias}";

        // Copy the template to temporary folder
        $this->copyTemplate($temp_dir);

        // Generate the inner portion of the form
        $this->generateInnerForm($input);

        // Save the module configuration as json
        $this->saveModuleConfig($input, $module_alias);

        // Adjust the template files, based on the input
        $this->adjustFiles($input, $temp_dir, $module_alias);

        // Finally compress the temporary folder
        $zip_file = $this->generateZip($module_alias);

        return $zip_file;
    }

    /**
     * Copy the module template to a temporary directory
     * @param $temp_dir
     * @throws \Exception
     */
    private function copyTemplate($temp_dir)
    {
        if (!File::exists($this->templatePath)) {
            throw new Exception('The module template directory "' . $this->templatePath . '" doesn\'t exist.');
        }

        File::copyDirectory(app_path() . '/services/module_template', $temp_dir);
    }

    /**
     * Save the module configuration to a json file
     * @param $input
     * @param $module_alias
     */
    private function saveModuleConfig($input, $module_alias)
    {
        $module_config = array(
            'enabled'     => true,
            'info'        => array(
                'name'      => $input['name'],
                'canonical' => $module_alias,
                'version'   => $input['version'],
                'author'    => $input['author'],
                'website'   => $input['website']
            ),
            // 'provider'    => 'App\Modules\\' . $module_title_case . '\\ServiceProvider',
            'table'       => $input['table_name'],
            'target'      => implode('|', $input['target']),
            'fields'      => $this->fields,
            'field_names' => $this->field_names
        );

        // Create the config file for module
        file_put_contents(temp_path() . "/{$module_alias}/module.json", json_encode($module_config));
    }

    /**
     * Generate the inner portion form based on the input
     * @param $input
     */
    private function generateInnerForm($input)
    {
        $selected_forms = array();
        $count = 0;

        for ($i = 1; $i <= $input['form-count']; $i++) {
            if (isset($input["form-{$i}"])) {
                $selected_forms[$count++] = $input["form-{$i}"];
                unset($input["form-{$i}"]);
            }
        }

        $this->nav_tabs = '<ul class="nav nav-tabs">';
        $this->form_rendered = '<div class="tab-content">';

        $extra_code = '';

        foreach ($selected_forms as $index => $selected_form) {
            if ($selected_form == 0) {
                continue;
            }

            $form = BuiltForm::find($selected_form);

            $form_json = json_decode(str_replace('\\', '', $form->data), true);

            // Get only required information fields from the form data
            for ($i = 1; $i < sizeof($form_json); $i++) {
                $this_form = $form_json[$i];
                if (!isset($this_form['fields']['id']) && !isset($this_form['fields']['radios'])) {
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

                if (in_array($type, array('text', 'input', 'textarea', 'radio', 'select')) && !isset($this_form['fields']['buttontype'])) {
                    $this->fields[] = $value;
                    $this->field_names[] = $field_name;
                }
            }

            $active = ($index == 0) ? 'active' : '';
            $this->nav_tabs .= '<li class="' . $active . '"><a href="#tab_1_' . $index . '" data-toggle="tab">' . $form->name . '</a></li>';

            $this->form_rendered .= '<div class="tab-pane ' . $active . '" id="tab_1_' . $index . '">';
            $form->rendered = str_replace("/\n/", '', $form->rendered);
            $form->rendered = str_replace("//", '', $form->rendered);
            $this->form_rendered .= preg_replace("/<legend>.*?<\/legend>/", '', $form->rendered);
            $this->form_rendered .= '</div>';

            $extra_code .= $form->extra_code;
        }

        $this->form = $form;
        $this->extra_code = $extra_code;
        $this->form_rendered .= '</div>';
        $this->nav_tabs .= '</ul>';
    }

    /**
     * Generate the complete form
     * @return string
     */
    private function generateForm()
    {
        $view = $this->nav_tabs;
        $view .= '<?php $link_type = ($link_type=="public") ? "" : $link_type . "." ?>' . "\n";
        $view .= '@if (!isset($entry))' . "\n";
        $view .= '{{ Form::open(array("route"=>"{$link_type}modules.".$module_link.".store", "method"=>"POST", "class"=>"form-horizontal", "files"=>true)) }}' . "\n";
        $view .= '@else' . "\n";
        $view .= '{{ Form::open(array("route" => array("{$link_type}modules.".$module_link.".update", $entry->id), "method"=>"PUT", "class"=>"form-horizontal", "files"=>true)) }}' . "\n";
        $view .= '@endif' . "\n";

        $form_data = str_replace('<form class="form-horizontal">', '', urldecode($this->form_rendered));
        $view .= str_replace('</form>', '', $form_data);

        // Add save buttons
        $view .= '<div class="form-actions">
                        <button type="submit" class="btn btn-primary" name="form_save">Save</button>

                        <button type="submit" class="btn btn-success" name="form_save_new">Save &amp; New</button>

                        <button type="submit" class="btn btn-primary btn-danger" name="form_close">Close</button>
                    </div>';

        $view .= '{{ Form::close() }}';

        return $view;
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
            $target = ($target == 'public') ? '' : $target . '/';
            $routes .= "Route::resource('{$target}modules/'.\$current_dir, 'Modules\ModuleName\Controllers\BackendController');\n";
        }

        return $routes;
    }

    /**
     * Adjust the template files according to the provided input
     * @param $input
     * @param $temp_dir
     * @param $module_alias
     */
    private function adjustFiles($input, $temp_dir, $module_alias)
    {
        $module_title_case = str_replace(' ', '', Str::title($input['name']));

        $this->SearchandReplace($temp_dir, 'NameOfTheModule', $input['name']);
        $this->SearchandReplace($temp_dir, 'VersionOfTheModule', $input['version']);
        $this->SearchandReplace($temp_dir, 'WebsiteOfTheModule', $input['website']);
        $this->SearchandReplace($temp_dir, 'DescriptionOfTheModule', $input['description']);

        // Generate the required routes
        $routes = $this->generateRoutes($input['target']);
        $this->SearchandReplace($temp_dir, '***ROUTES***', $routes);

        // Get the complete generated form
        $generated_form = $this->generateForm();
        $this->SearchandReplace($temp_dir, '***FORM_CONTENT***', $generated_form);

        if ($this->form->redirect_to == 'list') {
            $redirect_to = 'to($this->link . "modules/" . $this->module_name)';
        } elseif ($this->form->redirect_to == 'add') {
            $redirect_to = 'to($this->link . "modules/" . $this->module_name . "/create")';
        } else {
            $redirect_to = 'back()';
        }
        $this->SearchandReplace($temp_dir, '***REDIRECT_TO***', $redirect_to);

        $this->SearchandReplace($temp_dir, '***EXTRA_CODE***', str_replace('\\', '', $this->extra_code));

//        $this->SearchandReplace($temp_dir, 'Modules\\ModuleName', 'Modules\\' . $module_title_case);

        $this->SearchandReplace($temp_dir, 'CreateEntriesTable', 'Create' . $module_title_case . 'Table');

        $this->SearchandReplace($temp_dir, 'ModuleModel', 'Module' . $module_title_case);
        $this->SearchandReplace($temp_dir, 'ModuleName', $module_title_case);

        $this->SearchandReplace($temp_dir, 'module_entries', 'module_' . $input['table_name']);

        $table_fields = '';
        foreach ($this->fields as $field) {
            $table_fields .= "'$field',";
        }

        $this->SearchandReplace($temp_dir, 'table_fields', $table_fields);

        $this->renameFiles($input['name'], $temp_dir, $module_alias);
    }

    /**
     * @param $module_name
     * @param $temp_dir
     * @param $module_alias
     */
    private function renameFiles($module_name, $temp_dir, $module_alias)
    {
        $module_title_case = str_replace(' ', '', Str::title($module_name));

        rename($temp_dir . '/migrations/2013_10_14_094335_create_entries_table.php',
            $temp_dir . '/migrations/2013_10_14_094335_create_' . $module_alias . '_table.php');

        rename($temp_dir . '/models/ModuleModel.php',
            $temp_dir . '/models/Module' . $module_title_case . '.php');
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
     * @param [type] $source      [description]
     * @param [type] $destination [description]
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

        // die;
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

}
