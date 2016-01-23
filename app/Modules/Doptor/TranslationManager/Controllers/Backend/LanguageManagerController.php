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
use Response;
use View;

use Sentry;

use Backend\AdminController;
use Services\Validation\ValidationException as ValidationException;
use Modules\Doptor\TranslationManager\Models\TranslationLanguage;
use Modules\Doptor\TranslationManager\Services\LanguageService;

use Barryvdh\TranslationManager\Models\Translation;

class LanguageManagerController extends AdminController {

    public function __construct(LanguageService $language_service)
    {
        $this->language_service = $language_service;
        parent::__construct();

        View::addNamespace('language_manager',
            app_path() . "/Modules/Doptor/TranslationManager/Views/languages");
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $languages = TranslationLanguage::all();

        $this->layout->title = 'All Translation Languages';

        $this->layout->content = View::make('language_manager::index')
            ->with('languages', $languages);
    }

    /**
     * Export the language files for download
     * @param   $language_id
     * @return
     */
    public function export($language_id)
    {
        $language = TranslationLanguage::findOrFail($language_id);

        $zip_file = $this->language_service->export($language);

        return Response::download($zip_file);
    }

    /**
     * Show the page for installing a language file
     *
     */
    public function getInstall()
    {
        $this->layout->title = 'Install New Language';
        $this->layout->content = View::make('language_manager::install');
    }

    /**
     * Store a newly created installed module in storage.
     *
     */
    public function postInstall()
    {
       try {
            $file = Input::file('file');

            $input = $this->language_service->installLanguageFile($file);

            $language = TranslationLanguage::updateOrCreate($input);

            if ($language) {
                return Redirect::route("{$this->link_type}.modules.doptor.translation_manager.languages.index")
                    ->with('success_message', trans('success_messages.translate_lang_install'));
            } else {
                return Redirect::route("{$this->link_type}.modules.doptor.translation_manager.languages.index")
                    ->with('error_message', trans('error_messages.translate_lang_install'));
            }

        } catch (Exception $e) {
            return Redirect::back()
                ->withInput()
                ->with('error_message', trans('error_messages.module_install') . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $this->layout->title = 'New Language';

        $this->layout->content = View::make('language_manager::create_edit');
    }

    /**
     * Store a newly created resource in storage.
     * @return Response
     */
    public function store()
    {
        $input = Input::all();

        try {
            TranslationLanguage::create($input);

            $this->language_service->createLanguage($input['code']);

            return Redirect::route("{$this->link_type}.modules.doptor.translation_manager.languages.index")
                ->with('success_message', trans('success_messages.translate_lang_create'));
        } catch (ValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $this->layout->title = 'Edit Language';

        $this->layout->content = View::make('language_manager::create_edit')
            ->with('language', TranslationLanguage::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $input = Input::all();

        try {
            $language = TranslationLanguage::findOrFail($id);

            $language->update($input);

            return Redirect::route("{$this->link_type}.modules.doptor.translation_manager.languages.index")
                ->with('success_message', trans('success_messages.translate_lang_update'));
        } catch (ValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $language = TranslationLanguage::findOrFail($id);

        $language_path = base_path() . '/resources/lang/' . $language->code;

        if (File::exists($language_path)) {
            File::deleteDirectory($language_path);
        }

        // Delete the translations for the language
        Translation::where('locale', $language->code)->delete();

        if ($language->delete()) {
            return Redirect::route("{$this->link_type}.modules.doptor.translation_manager.languages.index")
                ->with('success_message', trans('success_messages.translate_lang_delete'));
        } else {
            return Redirect::route("{$this->link_type}.modules.doptor.translation_manager.languages.index")
                ->with('error_message', trans('error_messages.translate_lang_delete'));
        }
    }

}
