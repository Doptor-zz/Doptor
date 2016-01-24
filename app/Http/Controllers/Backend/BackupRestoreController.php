<?php namespace Backend;

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
use Exception;
use File;
use Input;
use Redirect;
use Response;
use Session;
use Str;
use View;

use Sentry;

use BuiltForm;
use BuiltModule;
use Module;
use Services\Synchronize;

class BackupRestoreController extends AdminController {

    public function getBackup()
    {
        $this->layout->title = 'Backup';
        $this->layout->content = View::make($this->link_type.'.'.$this->current_theme.'.backup_restore.backup');
    }

    public function postBackup()
    {
        $this->current_time = date("Y-m-d-H-i-s");
        $this->backup_dir = backup_path() . "/backup/";
        $this->backup_file = backup_path() . "/backup_{$this->current_time}.zip";
        $this->restore_file = restore_path() . "/backup_{$this->current_time}.zip";

        $synchronizer = new Synchronize($this);

        $synchronizer->startBackup();

        return Response::download($this->backup_file, "backup_{$this->current_time}.zip");
    }

    public function getRestore()
    {
        $this->layout->title = 'Restore from Backup';
        $this->layout->content = View::make($this->link_type.'.'.$this->current_theme.'.backup_restore.restore');
    }

    public function postRestore()
    {
        Sentry::logout();

        $synchronizer = new Synchronize($this);

        $restore_file = $synchronizer->copyToRestore(Input::all());

        $synchronizer->restore($restore_file);

        return Redirect::to('/');
    }
}
