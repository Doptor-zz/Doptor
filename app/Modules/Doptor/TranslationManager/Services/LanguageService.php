<?php namespace Modules\Doptor\TranslationManager\Services;

/*
=================================================
CMS Name  :  DOPTOR
CMS Version :  v1.2
Available at :  www.doptor.org
Copyright : Copyright (coffee) 2011 - 2015 Doptor. All rights reserved.
License : GNU/GPL, visit LICENSE.txt
Description :  Doptor is Opensource CMS.
===================================================
*/
use Exception;
use File;

use Barryvdh\TranslationManager\Manager;

class LanguageService {

    private $language_path;
    private $temp_path;
    private $export_temp_path;

    public function __construct(Manager $translation_manager)
    {
        $this->translation_manager = $translation_manager;
        $this->language_path = base_path() . '/resources/lang/';
        $this->temp_path = temp_path() . '/';
    }

    public function createLanguage($language_code)
    {
        $this->copyLanguageFiles($language_code);

        $this->translation_manager->importTranslations();
    }

    /**
     * Copy language files from default language(en)
     * to the newly created language
     */
    private function copyLanguageFiles($language_code)
    {
        $en_language_path = $this->language_path . 'en/';
        $new_language_path = $this->language_path . $language_code . '/';

        File::copyDirectory($en_language_path, $new_language_path);
    }

    public function export($language)
    {
        $language_path = $this->language_path . $language->code . '/';

        if (File::exists($language_path)) {
            $file_name = "doptor_translation_{$language->code}";
            $this->export_temp_path = temp_path() . '/translations_export/' . $file_name;

            if (File::exists($this->export_temp_path) && !is_file($this->export_temp_path)) {
                // delete old exported files
                File::deleteDirectory($this->export_temp_path);
            }

            $temp_lang_path = $this->export_temp_path . '/lang';
            File::copyDirectory($language_path, $temp_lang_path);

            $this->writeConfig($language);

            $zip_file = $this->export_temp_path . ".zip";
            Zip($this->export_temp_path, $zip_file, false);

            return $zip_file;
        }
    }

    private function writeConfig($language)
    {
        $config = [
            'name' => $language->name,
            'code' => $language->code
        ];

        file_put_contents($this->export_temp_path . '/language.json', json_encode($config));
    }

    public function installLanguageFile($file)
    {
        $filename = $this->uploadLanguageFile($file);

        $filename = str_replace('.ZIP', '.zip', $filename);
        $canonical = str_replace('.zip', '', $filename);

        $temp_import_path = temp_path() . '/translations_import/' . $canonical . '/';

        if (File::exists($temp_import_path)) {
            File::deleteDirectory($temp_import_path);
        }

        $unzipSuccess = Unzip("{$this->temp_path}{$filename}", $temp_import_path);
        if (!$unzipSuccess) {
            throw new Exception("The language file {$filename} couldn\'t be extracted.");
        }

        if (!File::exists("{$temp_import_path}language.json")) {
            throw new Exception('language.json doesn\'t exist in the language file');
        }

        $language_config = json_decode(file_get_contents("{$temp_import_path}/language.json"), true);
        
        $language_dir = $this->language_path . $language_config['code'];
        File::copyDirectory($temp_import_path . 'lang', $language_dir);

        // Import the translations from file to database
        $this->translation_manager->importTranslations();

        return $language_config;
    }

    /**
     * Upload the language file to server
     * @param $file
     * @throws \Exception
     * @return array
     */
    public function uploadLanguageFile($file)
    {
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        if ($extension == '') {
            $filename = $filename . '.zip';
        }

        $full_filename = $this->temp_path . $filename;
        File::exists($full_filename) && File::delete($full_filename);

        $uploadSuccess = $file->move($this->temp_path, $filename);

        return $filename;
    }
}
