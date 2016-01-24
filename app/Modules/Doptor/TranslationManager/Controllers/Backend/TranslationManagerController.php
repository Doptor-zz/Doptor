<?php namespace Modules\Doptor\TranslationManager\Controllers\Backend;
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
use App;
use File;
use Input;
use Redirect;
use View;

use Sentry;

use Backend\AdminController;
use Services\Validation\ValidationException as ValidationException;
use Modules\Doptor\TranslationManager\Models\TranslationLanguage;
use Barryvdh\TranslationManager\Models\Translation;
use Barryvdh\TranslationManager\Manager;

class TranslationManagerController extends AdminController {

    private $translation_manager;

    public function __construct(Manager $translation_manager)
    {
        $this->translation_manager = $translation_manager;
        // $this->translation_manager->truncateTranslations();
        // $this->translation_manager->importTranslations();
        parent::__construct();

        View::addNamespace('translation_manager',
            app_path() . "/Modules/Doptor/TranslationManager/Views/translations");
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index($language_id)
    {
        $language = TranslationLanguage::findOrFail($language_id);

        $groups = Translation::where('locale', $language->code)->groupBy('group')->get();

        $this->layout->title = 'All Translation For: ' . $language->name;

        $this->layout->content = View::make('translation_manager::index')
            ->with('language', $language)
            ->with('groups', $groups);
    }

    public function getManage($language_id, $group)
    {
        $language = TranslationLanguage::findOrFail($language_id);

        $allTranslations = Translation::where('group', $group)->orderBy('key', 'asc')->get();

        $numTranslations = count($allTranslations);
        $translations = [];
        foreach($allTranslations as $translation){
            $translations[$translation->key][$translation->locale] = $translation;
        }

        $locales = ['en', $language->code];
        $this->layout->title = 'Manage Translations';

        $this->layout->content = View::make('translation_manager::translations')
            ->with('language_id', $language_id)
            ->with('group', $group)
            ->with('locales', $locales)
            ->with('translations', $translations);
    }

    public function postManage($language_id, $group)
    {
        $language = TranslationLanguage::findOrFail($language_id);

        $input = Input::all();

        unset($input['_token']);

        foreach ($input as $key => $value) {
            $translation = Translation::where('locale', $language->code)
                        ->where('key', $key)->first();
            if ($translation) {
                $value = str_replace('**script**', '<script>', $value);
                $value = str_replace('**/script**', '</script>', $value);
                $translation->value = $value;
                $translation->save();
            }
        }

        $this->translation_manager->exportTranslations($group);

        return Redirect::route("{$this->link_type}.modules.doptor.translation_manager.index", [$language_id])
                ->with('success_message', 'The translations were changed.');
    }
}
