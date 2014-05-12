<?php
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
class InstallController extends Controller {

    protected $layout = 'install._layout';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($step=1)
    {
        switch ($step) {
            case 1:
                return View::make('install.db_config')
                                ->with('title', 'Step 1');
                break;

            case 2:
                return View::make('install.db_success')
                                ->with('title', 'Step 2');
                break;

            case 3:
                return View::make('install.site_config')
                                ->with('title', 'Step 3');
                break;

            case 4:
                return View::make('install.completed')
                                ->with('title', 'Completed');
                break;

            default:
                # code...
                break;
        }
    }

    public function configure($step=1)
    {
        $installer = new Services\Installer($this);

        try {
            switch ($step) {
                case 1:
                    return $installer->dbConnection(Input::all());
                    break;

                case 2:
                    break;

                case 3:
                    return $installer->dbMigrate(Input::all());
                    break;
            }
        } catch (Exception $e) {
            return Redirect::back()
                            ->withInput()
                            ->with('error_message', $e->getMessage());
        }
    }

    public function delete_files()
    {
        Event::fire('installer.delete');

        return Redirect::to('/');
    }

    /**
     * Handle any validation errors
     * @param  Validator $validator
     * @return Redirect
     */
    public function validationErrors($validator)
    {
        return Redirect::back()
                            ->withInput()
                            ->withErrors($validator);
    }

    public function installerFails($errors)
    {
        return Redirect::back()
                            ->withInput()
                            ->with('error_message', $errors);
    }

    public function installerSucceeds($redirect_to)
    {
        return Redirect::to($redirect_to);
    }
}
