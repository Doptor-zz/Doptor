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

class SlideshowController extends AdminController {

    /**
	 * Display a listing of the resource.
	 * @return Response
	 */
	public function index()
	{


        $slides = Slideshow::all();

        $this->layout->title = 'All Slides';

        $this->layout->content = View::make('backend.'.$this->current_theme.'.slideshow.index')
                                        ->with('slides', $slides);
	}

	/**
	 * Show the form for creating a new resource.
	 * @return Response
	 */
	public function create()
	{


        $this->layout->title = 'New slide';
        $this->layout->content = View::make('backend.'.$this->current_theme.'.slideshow.create_edit');
	}

	/**
	 * Store a newly created resource in storage.
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
        $input['created_by'] = Sentry::getUser()->id;

        try
        {
            $slide = new Slideshow($input);
            $slide->save();

            return Redirect::to("backend/slideshow")
                                ->with('success_message', 'The slide was added.');
        }

        catch(ValidationException $e)
        {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        return View::make('slideshows.show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{


        $this->layout->title = 'Edit slide';

        $this->layout->content = View::make('backend.'.$this->current_theme.'.slideshow.create_edit')
                                        ->with('slide', Slideshow::findOrFail($id));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::all();
        $input['updated_by'] = Sentry::getUser()->id;

        try
        {
            $slide = Slideshow::findOrFail($id);

            $slide->update($input);

            return Redirect::to("backend/slideshow")
                                ->with('success_message', 'The slideshow was updated.');
        }

        catch(ValidationException $e)
        {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{


        $slide = Slideshow::findOrFail($id);

        if (!$slide) App::abort('401');

        File::delete($slide->image);
        if ($slide->delete()) {
            return Redirect::to("backend/slideshow")
                                ->with('success_message', 'The slide was deleted.');
        } else {
            return Redirect::to("backend/slideshow")
                                ->with('error_message', 'The slide was not deleted.');
        }
	}

}
