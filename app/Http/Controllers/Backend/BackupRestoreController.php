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

use Backup;
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

        $backup_description = 'Manual backup created';
        $synchronizer->saveBackupToDB($backup_description);

        return Response::download($this->backup_file, "backup_{$this->current_time}.zip");
    }

    public function getRestore()
    {
        $backups = Backup::latest()->get();

        $this->layout->title = 'Restore from Backup';
        $this->layout->content = View::make($this->link_type.'.'.$this->current_theme.'.backup_restore.restore')
                                    ->with('backups', $backups);
    }

    public function getRestoreFromFile()
    {
        $this->layout->title = 'Restore from Backup File';
        $this->layout->content = View::make($this->link_type.'.'.$this->current_theme.'.backup_restore.restore_from_file');
    }

    public function postRestore()
    {
        $input = Input::all();

        $synchronizer = new Synchronize($this);

        if (isset($input['backup_id'])) {
            $backup = Backup::findOrFail($input['backup_id']);

            $restore_file = $backup->file;
        } else {
            $restore_file = $synchronizer->copyToRestore($input);
        }

        Sentry::logout();

        $synchronizer->restore($restore_file);

        return Redirect::to('/');
    }

    public function deleteBackup($id)
    {
        $backup = Backup::findOrFail($id);

        if (File::exists($backup->file) && is_file($backup->file)) {
            File::delete($backup->file);

            if ($backup->delete()) {
                return Redirect::to('backend/restore')
                    ->with('success_message', trans('success_messages.backup_delete'));
            } else {
                return Redirect::to('backend/restore')
                    ->with('error_message', trans('error_messages.backup_delete'));
            }
        }
    }
}
