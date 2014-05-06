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
use App, Exception, File, Input, Str, View, Redirect, Response;
use BuiltForm, Module;

class ModuleBuilder {

    public static function create_module($input)
    {
        $canonical = Str::slug($input['name'], '_');
        $input['table_name'] = ($input['table_name']=='') ? $canonical : $input['table_name'];
        $temp_dir = temp_path() . "/{$canonical}/{$canonical}";

        // Copy the template to temporary folder
        if (!File::exists(app_path() . '/services/module_template/')) {
            throw new Exception('The module template directory "' . app_path() . '/services/module_template/" doesn\'t exist.' );

        }
        File::copyDirectory(app_path() . '/services/module_template', $temp_dir);

        $selected_forms = array();
        $count = 0;

        for ($i=1; $i <= $input['form-count']; $i++) {
            if (isset($input["form-{$i}"])) {
                $selected_forms[$count++] = $input["form-{$i}"];
                unset($input["form-{$i}"]);
            }
        }

        $nav_tabs = '<ul class="nav nav-tabs">';
        $form_rendered = '<div class="tab-content">';

        $fields = array();
        $field_names = array();
        $extra_code = '';

        foreach ($selected_forms as $index => $selected_form) {
            if ($selected_form == 0) {
                continue;
            }

            $form = BuiltForm::find($selected_form);

            $form_json = json_decode(str_replace('\\', '', $form->data), true);

            // Get only required information fields from the form data
            for ($i=1; $i < sizeof($form_json); $i++) {
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
                    $fields[] = $value;
                    $field_names[] = $field_name;
                }
            }

            $active = ($index==0) ? 'active' : '';
            $nav_tabs .= '<li class="'.$active.'"><a href="#tab_1_'.$index.'" data-toggle="tab">'.$form->name.'</a></li>';

            $form_rendered .= '<div class="tab-pane '.$active.'" id="tab_1_'.$index.'">';
            $form->rendered = str_replace("/\n/", '', $form->rendered);
            $form->rendered = str_replace("//", '', $form->rendered);
            $form_rendered .= preg_replace("/<legend>.*?<\/legend>/", '', $form->rendered);
            $form_rendered .= '</div>';

            $extra_code .= $form->extra_code;
        }

        $form_rendered .= '</div>';
        $nav_tabs .= '</ul>';

        $module_config = array(
                            'enabled'  => true,
                            'info' => array(
                                    'name'      => $input['name'],
                                    'canonical' => $canonical,
                                    'version'   => $input['version'],
                                    'author'    => $input['author'],
                                    'website'   => $input['website']
                            ),
                            'provider'    => 'App\Modules\\'.str_replace(' ', '_', Str::title($input['name'])).'\\ServiceProvider',
                            'table'       => $input['table_name'],
                            'target'      => implode('|', $input['target']),
                            'fields'      => $fields,
                            'field_names' => $field_names
                        );

        // Create the config file for module
        file_put_contents(temp_path() . "/{$canonical}/module.json", json_encode($module_config));

        // Add form content
        $view = $nav_tabs;
        $view .= '<?php $link_type = ($link_type=="public") ? "" : $link_type . "." ?>' . "\n";
        $view .= '@if (!isset($entry))' ."\n";
        $view .= '{{ Form::open(array("route"=>"{$link_type}modules.".$module_name.".store", "method"=>"POST", "class"=>"form-horizontal", "files"=>true)) }}' ."\n";
        $view .= '@else' . "\n";
        $view .= '{{ Form::open(array("route" => array("{$link_type}modules.".$module_name.".update", $entry->id), "method"=>"PUT", "class"=>"form-horizontal", "files"=>true)) }}' . "\n";
        $view .= '@endif' . "\n";

        $form_data = str_replace('<form class="form-horizontal">', '', urldecode($form_rendered));
        $view .= str_replace('</form>', '', $form_data);

        // Add save buttons
        $view .= '<div class="form-actions">
                        <button type="submit" class="btn btn-primary" name="form_save">Save</button>

                        <button type="submit" class="btn btn-success" name="form_save_new">Save &amp; New</button>

                        <button type="submit" class="btn btn-primary btn-danger" name="form_close">Close</button>
                    </div>';

        $view .= '{{ Form::close() }}';

        if ($form->redirect_to == 'list') {
            $redirect_to = 'to($this->link . "modules/" . $this->module_name)';
        } elseif ($form->redirect_to == 'add') {
            $redirect_to = 'to($this->link . "modules/" . $this->module_name . "/create")';
        } else {
            $redirect_to = 'back()';
        }

        ModuleBuilder::SearchandReplace($temp_dir, 'NameOfTheModule', $input['name']);
        ModuleBuilder::SearchandReplace($temp_dir, 'VersionOfTheModule', $input['version']);
        ModuleBuilder::SearchandReplace($temp_dir, 'WebsiteOfTheModule', $input['website']);
        ModuleBuilder::SearchandReplace($temp_dir, 'DescriptionOfTheModule', $input['description']);
        ModuleBuilder::SearchandReplace($temp_dir, '***FORM_CONTENT***', $view);
        ModuleBuilder::SearchandReplace($temp_dir, '***EXTRA_CODE***', str_replace('\\', '', $extra_code));
        ModuleBuilder::SearchandReplace($temp_dir, '***REDIRECT_TO***', $redirect_to);

        $route = '';
        foreach ($input['target'] as $target) {
            $target = ($target == 'public') ? '' : $target . '/';
            $route .= "Route::resource('{$target}modules/'.\$current_dir, 'ModuleNameBackendController');\n";
        }

        ModuleBuilder::SearchandReplace($temp_dir, '***ROUTES***', $route);

        $input['target'] = implode(' ', $input['target']);

        unset($input['_token']);
        unset($input['confirmed']);

        ModuleBuilder::SearchandReplace($temp_dir, 'namespace App\Modules\\Content', 'namespace App\Modules\\'.str_replace(' ', '_', Str::title($input['name'])));

        ModuleBuilder::SearchandReplace($temp_dir, 'CreateEntriesTable', 'Create'.str_replace(' ', '', Str::title($input['name'])).'Table');

        rename($temp_dir.'/migrations/2013_10_14_094335_create_entries_table.php', $temp_dir.'/migrations/2013_10_14_094335_create_'.$canonical.'_table.php');


        ModuleBuilder::SearchandReplace($temp_dir, 'ModuleEntry', 'Module'.str_replace(' ', '', Str::title($input['name'])));
        ModuleBuilder::SearchandReplace($temp_dir, 'ModuleName', str_replace(' ', '', Str::title($input['name'])));

        ModuleBuilder::SearchandReplace($temp_dir, 'module_entries', 'module_'.$input['table_name']);

        $table_fields = '';
        foreach ($fields as $field) {
            $table_fields .= "'$field',";
        }

        ModuleBuilder::SearchandReplace($temp_dir, 'table_fields', $table_fields);

        // rename($temp_dir.'/controllers/ModuleNameFrontendController.php', $temp_dir.'/controllers/'.str_replace(' ', '', Str::title($input['name'])).'FrontendController.php');
        rename($temp_dir.'/controllers/ModuleNameBackendController.php', $temp_dir.'/controllers/'.str_replace(' ', '', Str::title($input['name'])).'BackendController.php');

        rename($temp_dir.'/models/ModuleEntry.php', $temp_dir.'/models/Module'.str_replace(' ', '', Str::title($input['name'])).'.php');

        // Finally compress the temporary folder
        $zip_file = temp_path() . "/{$canonical}.zip";
        ModuleBuilder::Zip(temp_path() . "/{$canonical}/", $zip_file, false);
        File::deleteDirectory(temp_path() . "/{$canonical}/");
        // $form = Module::create ($input);
        return $zip_file;
    }

    /**
     * Compresses a folder
     * @param [type] $source      [description]
     * @param [type] $destination [description]
     */
    public static function Zip($source, $destination, $include_dir = true)
    {
        if (!extension_loaded('zip') || !file_exists($source)) {
            return false;
        }

        if (file_exists($destination)) {
            unlink ($destination);
        }

        $zip = new \ZipArchive();
        if (!$zip->open($destination, \ZIPARCHIVE::CREATE)) {
            return false;
        }
        $source = str_replace('\\', '/', realpath($source));
        if (is_dir($source) === true) {
            $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($source), \RecursiveIteratorIterator::SELF_FIRST);

            if ($include_dir) {
                $arr = explode("/",$source);
                $maindir = $arr[count($arr)- 1];

                $source = "";
                for ($i=0; $i < count($arr) - 1; $i++) {
                    $source .= '/' . $arr[$i];
                }

                $source = substr($source, 1);

                $zip->addEmptyDir($maindir);
            }

            foreach ($files as $file) {
                // Ignore "." and ".." folders
                if( in_array(substr($file, strrpos($file, DIRECTORY_SEPARATOR)+1), array('.', '..', ':')) )
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
     * @param string $dir           Source Directory
     * @param string $stringsearch  String to search
     * @param string $stringreplace String to replace
     */
    public static function SearchandReplace($dir, $stringsearch, $stringreplace)
    {
        $listDir = array();
        if($handler = opendir($dir)) {
            while (($sub = readdir($handler)) !== FALSE) {
                if ($sub != "." && $sub != ".." && $sub != "Thumb.db") {
                    if(is_file($dir."/".$sub)) {
                        if(substr_count($sub,'.php'))
                        {
                            $getfilecontents = file_get_contents($dir."/".$sub);
                            if(substr_count($getfilecontents,$stringsearch)>0)
                            {
                                $replacer = str_replace($stringsearch,$stringreplace,$getfilecontents);
                                // Let's make sure the file exists and is writable first.
                                if (is_writable($dir."/".$sub)) {
                                    if (!$handle = fopen($dir."/".$sub, 'w')) {
                                        // echo "Cannot open file (".$dir."/".$sub.")";
                                        exit;
                                    }
                                // Write $somecontent to our opened file.
                                    if (fwrite($handle, $replacer) === FALSE) {
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
                    }elseif(is_dir($dir."/".$sub)){
                        $listDir[$sub] = ModuleBuilder::SearchandReplace($dir."/".$sub,$stringsearch,$stringreplace);
                    }
                }
            }
            closedir($handler);
        }
        return $listDir;
    }

}
