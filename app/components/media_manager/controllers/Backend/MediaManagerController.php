<?php namespace Components\MediaManager\Controllers\Backend;
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
use App, Exception, Input, MediaEntry, Redirect, Request, Response, Sentry, Str, View, File;
use Services\Validation\ValidationException as ValidationException;

class MediaManagerController extends BaseController {

    public function __construct()
    {
        // Add location hinting for views
        // View::addLocation(app_path().'/components/media_manager/views');
        // View::addNamespace('media_manager', app_path().'/components/media_manager/views');

        parent::__construct();
    }

    /**
     * Show the form for creating a new media_entry.
     *
     * @return Response
     */
    public function index()
    {
        if (Request::ajax()) {
            $this->layout = View::make($this->link_type.'.'.$this->current_theme.'._layouts._modal');
            $ajax = true;
        } else {
            $ajax = false;
        }

        $this->layout->title = 'Media Manager';
        $this->layout->content = View::make($this->link_type.'.'.$this->current_theme.'.media_manager.create_edit')
                                        ->with('base_dir', 'uploads')
                                        ->with('ajax', $ajax);
    }

    public function folder_contents()
    {
        $dir = Input::get('dir', '');

        $files = array();

        foreach (File::files("{$dir}") as $key => $file) {
            $split = explode('/', $file);
            $file_name = array_pop($split);
            $thumbnail = implode('/', $split) . '/thumbs/' . $file_name;
            if (File::exists($thumbnail)) {
                $files[] = $thumbnail;
            } else {
                $files[] = $file;
            }
        }

        $dirs = array();

        foreach (File::directories("{$dir}") as $dir) {
            if (!str_contains($dir, 'thumbs')) {
                $dir_name = str_replace('\\', '/', $dir);
                $dirs[] = $dir_name;
            }
        }

        $ret =  array(
                'files' => $files,
                'dirs'  => $dirs
            );
        return Response::json($ret, 200);
    }

    public function create_folder()
    {
        $dir = Input::get('dir', '');

        if (File::makeDirectory(public_path() . "/{$dir}")) {
            return Response::json('Success', 200);
        } else {
            return Response::json('Error', 400);
        }
    }

    /**
     * Store a newly created media_entry in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();
        // return Response::json($input['folder'], 400);
        $input['image'] = $input['file'];
        unset($input['file']);

        try {
            $media_entry = MediaEntry::create($input);

            if ($media_entry) {
               return Response::json('Success', 200);
            } else {
               return Response::json('Error', 400);
            }

        } catch (ValidationException $e) {
            return Response::make($validation->errors->first(), 400);
        } catch (Exception $e) {
            return Response::make($e->getMessage(), 400);
        }
    }

    /**
     * Display the specified media_entry.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {


        $media_entry = MediaEntry::findOrFail($id);

        $this->layout->title = $media_entry->title;
        $this->layout->content = View::make($this->link_type.'.'.$this->current_theme.'.media_manager.show')
                                        ->with('media_entry', $media_entry);
    }

    /**
     * Show the form for editing the specified media_entry.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

        $this->layout->title = 'Edit Media Entry';
        $this->layout->content = View::make($this->link_type.'.'.$this->current_theme.'.media_manager.create_edit')
                                        ->with('media_entry', MediaEntry::findOrFail($id));
    }

    /**
     * Update the specified media_entry in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $input = Input::all();

        try
        {
            $media_entry = MediaEntry::findOrFail($id);

            $media_entry->update($input);

            return Redirect::to("backend/media-manager")
                                ->with('success_message', 'The media entry was updated.');
        }

        catch(ValidationException $e)
        {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Remove the specified media_entry from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id=null)
    {
        $file = Input::get('file');
        $split = explode('/', $file);
        $file_name = array_pop($split);
        $thumbnail = implode('/', $split) . '/thumbs/' . $file_name;

        if (File::exists($thumbnail)) {
            File::delete($thumbnail);
        }

        if (File::exists($file)) {
            File::delete($file);
        }

        return Response::json('Success', 200);

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
            $media_entry = MediaEntry::findOrFail($id);

            File::delete($media_entry->image);
            File::delete($media_entry->thumbnail);

            $media_entry->delete();
        }

        $wasOrWere = (count($selected_ids) > 1) ? ' were' : ' was';
        $message = 'The media entry'. $wasOrWere . ' deleted.';

        return Redirect::to("backend/media-manager")
                                ->with('success_message', $message);
    }
}
