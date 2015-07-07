<?php
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

use App\Events\InstallationWasCompleted;

class InstallController extends Controller {

    protected $layout = 'install._layout';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($step=0)
    {
        switch ($step) {
            case 0:
                if (File::exists(base_path('license.txt'))) {
                    $license_text = file_get_contents(base_path('license.txt'));
                } else {
                    $license_text = '';
                }
                return view('install.license')
                                ->with('title', 'Setup: License Agreement')
                                ->with('license_text', $license_text);
                break;

            case 1:
                return view('install.db_config')
                                ->with('title', 'Setup: Step 1');
                break;

            case 2:
                return view('install.db_success')
                                ->with('title', 'Setup: Step 2');
                break;

            case 3:
                return view('install.site_config')
                                ->with('title', 'Setup: Step 3');
                break;

            case 4:
                return view('install.completed')
                                ->with('title', 'Setup: Completed');
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
        Event::fire(new InstallationWasCompleted());

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
