<?php namespace Components\Posts\Controllers\Backend;
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
use App, Input, Post, Redirect, Request, Sentry, Str, View, File;
use Services\Validation\ValidationException as ValidationException;

class PostsController extends BaseController {

    protected $type;

    public function __construct()
    {
        // Add location hinting for views
        View::addLocation(app_path().'/components/posts/views');
        View::addNamespace('posts', app_path().'/components/posts/views');

        if (Request::is('backend/pages*')) {
            $this->type = 'page';
        } else {
            $this->type = 'post';
        }
        View::share('type', $this->type);
        parent::__construct();
    }

    /**
     * Display a listing of the posts.
     *
     * @return Response
     */
    public function index()
    {
        $posts = Post::type($this->type)
                        ->get();

        $this->layout->title = 'All ' . Str::title($this->type) . 's';

        $this->layout->content = View::make($this->link_type.'.'.$this->current_theme.'.posts.index')
                                        ->with('posts', $posts);
    }

    /**
     * Show the form for creating a new post.
     *
     * @return Response
     */
    public function create()
    {
        $this->layout->title = 'New ' . Str::title($this->type);
        $this->layout->content = View::make($this->link_type.'.'.$this->current_theme.'.posts.create_edit');
    }

    /**
     * Store a newly created post in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();

        if (isset($input['form_close'])) {
            return Redirect::to("backend/{$input['type']}s");
        }

        $categories = Input::get('categories', array());

        try {
            $post = Post::create($input);

            $post->categories()->sync($categories);

            $redirect = (isset($input['form_save'])) ? "backend/{$input['type']}s" : "backend/{$input['type']}s/create";

            return Redirect::to($redirect)
                                ->with('success_message', 'The ' . $this->type . ' was created.');
        } catch(ValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Display the specified post.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);

        if (!$post) App::abort('401');

        $this->layout->title = $post->title;
        $this->layout->content = View::make($this->link_type.'.'.$this->current_theme.'.posts.show')
                                        ->with('post', $post);
    }

    /**
     * Show the form for editing the specified post.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $this->layout->title = 'Edit ' . Str::title($this->type);
        $this->layout->content = View::make($this->link_type.'.'.$this->current_theme.'.posts.create_edit')
                                        ->with('post', Post::findOrFail($id));
    }

    /**
     * Update the specified post in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $input = Input::all();

        if (isset($input['form_close'])) {
            return Redirect::to("backend/{$input['type']}s");
        }

        $categories = Input::get('categories', array());

        try {
            $post = Post::findOrFail($id);

            $post->update($input);

            $post->categories()->sync($categories);

            $redirect = (isset($input['form_save'])) ? "backend/{$input['type']}s" : "backend/{$input['type']}s/create";

            return Redirect::to($redirect)
                                ->with('success_message', 'The ' . $this->type . ' was updated.');
        } catch(ValidationException $e) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Remove the specified post from storage.
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
            $post = Post::findOrFail($id);

            File::delete($post->image);

            $post->delete();
        }

        $wasOrWere = (count($selected_ids) > 1) ? 's were' : ' was';
        $message = 'The ' . $post->type . $wasOrWere . ' deleted.';

        return Redirect::to("backend/{$post->type}s")
                                ->with('success_message', $message);
    }
}
