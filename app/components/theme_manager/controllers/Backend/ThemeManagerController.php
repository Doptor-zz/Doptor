<?php namespace Components\ThemeManager\Controllers\Backend;
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
use Backend\AdminController as BaseController;
use App, Exception, Input, Theme, Redirect, Request, Response, Sentry, Str, View, File;
use Services\Validation\ValidationException as ValidationException;

class ThemeManagerController extends BaseController {

    public function __construct()
    {
        // Add location hinting for views
        View::addLocation(app_path().'/components/theme_manager/views');
        View::addNamespace('theme_manager', app_path().'/components/theme_manager/views');

        parent::__construct();
    }

    /**
     * Display a listing of the theme_manager.
     *
     * @return Response
     */
    public function index()
    {


        $themes = Theme::get();

        $this->layout->title = 'Theme Manager';

        $this->layout->content = View::make($this->link_type.'.'.$this->current_theme.'.theme_manager.index')
                                        ->with('themes', $themes);
    }

    /**
     * Show the form for creating a new theme.
     *
     * @return Response
     */
    public function create()
    {


        $this->layout->title = 'New Theme Entry';
        $this->layout->content = View::make($this->link_type.'.'.$this->current_theme.'.theme_manager.create_edit');
    }

    /**
     * Store a newly created theme in storage.
     *
     * @return Response
     */
    public function store()
    {


        $theme_installer = new \Components\ThemeManager\Services\ThemeInstaller($this, Input::all());

        return $theme_installer->installTheme();
    }

    /**
     * Display the specified theme.
     *
     * @param  int  $id
     * @return Response
     */
    public function apply($id)
    {
        $theme = Theme::findOrFail($id);

        \Setting::setValue("{$theme->target}_theme", $theme->id);

        return Redirect::to('backend/theme-manager')
                            ->with('success_message', 'The theme was successfully applied');
    }

    /**
     * Remove the specified theme from storage.
     *
     * @param  int  $id
     * @return Response
     */
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
            $theme = Theme::findOrFail($id);

            if (\Setting::value("{$theme->target}_theme") == $theme->id) {
                return Redirect::back()
                                ->with('error_message', "The theme {$theme->name} can not be deleted because it is currently being used as {$theme->target} theme.");
            }

            File::delete($theme->screenshot);

            File::deleteDirectory(app_path() . "/views/{$theme->target}/{$theme->directory}/", false);
            File::deleteDirectory(public_path() . "/assets/{$theme->target}/{$theme->directory}/", false);

            $theme->delete();
        }

        $wasOrWere = (count($selected_ids) > 1) ? 's were' : ' was';
        $message = 'The theme'. $wasOrWere . ' deleted.';

        return Redirect::to("backend/theme-manager")
                                ->with('success_message', $message);
    }

    public function installerFails($errors)
    {
        return Redirect::back()
                            ->withInput()
                            ->with('error_message', $errors);
    }

    public function installerSucceeds($redirect_to, $message='')
    {
        return Redirect::to($redirect_to)
                            ->with('success_message', $message);
    }
}
