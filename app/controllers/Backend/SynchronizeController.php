<?php namespace Backend;
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
use App, Input, Slideshow, Redirect, Request, Sentry, Str, View, File;
use Services\Validation\ValidationException as ValidationException;

class SynchronizeController extends AdminController {

    public function __construct()
    {
        @ini_set('max_execution_time', 300);     // Temporarily increase maximum execution time
        parent::__construct();
        $this->current_time = date("Y-m-d-H-i-s");
        $this->backup_dir = backup_path() . "/backup/";
        $this->backup_file = backup_path() . "/backup_{$this->current_time}.zip";
        $this->restore_file = restore_path() . "/backup_{$this->current_time}.zip";
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        $this->layout->title = 'Synchronize';
        $this->layout->content = \View::make($this->link_type.'.'.$this->current_theme.'.synchronize.index');
    }

    public function getLocalToWeb()
    {
        $this->layout->title = 'Synchronize Local to Web';
        $this->layout->content = \View::make($this->link_type.'.'.$this->current_theme.'.synchronize.localtoweb');
    }

    public function postLocalToWeb()
    {
        $synchronizer = new \Services\Synchronize($this);
        return $synchronizer->startLocalToRemoteSync(Input::all());
    }

    public function getWebToLocal()
    {
        $this->layout->title = 'Synchronize Web to Local';
        $this->layout->content = \View::make($this->link_type.'.'.$this->current_theme.'.synchronize.webtolocal');
    }

    public function postWebToLocal()
    {
        $synchronizer = new \Services\Synchronize($this);
        return $synchronizer->startRemoteToLocalSync(Input::all());
    }

    public function postSyncFromFile()
    {
        $synchronizer = new \Services\Synchronize($this);

        $restore_file = $synchronizer->copyToRestore(Input::all());

        $synchronizer->restore($restore_file);

        return Redirect::to('/');
    }

    public function postSyncToFile()
    {
        $synchronizer = new \Services\Synchronize($this);

        $synchronizer->startBackup();

        return \Response::download($this->backup_file, "backup_{$this->current_time}.zip");
    }

    public function syncSucceeds($message)
    {
        return Redirect::to('backend/synchronize')
                        ->with('success_message', $message);
    }

    public function syncFails($errors, $redirect_to)
    {
        return Redirect::to($redirect_to)
                        ->withInput()
                        ->with('error_message', $errors);
    }
}
