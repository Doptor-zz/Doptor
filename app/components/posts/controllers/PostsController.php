<?php namespace Components\Posts\Controllers;
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
use BaseController;
use App, Input, Redirect, Request, Sentry, Str, View;
use Post, Category;
use Services\Validation\ValidationException as ValidationException;

class PostsController extends BaseController {

    public function __construct()
    {
        // Add location hinting for views
        View::addLocation(app_path().'/components/posts/views');
        View::addNamespace('posts', app_path().'/components/posts/views');

        if (Request::is('pages*')) {
            $this->type = 'page';
        } else {
            $this->type = 'post';
        }

        parent::__construct();
    }

    /**
     * Display a listing of the posts.
     *
     * @return Response
     */
    public function index()
    {
        $posts = Post::type($this->type)->target('public')->published()->recent()->paginate(5);

        $this->layout->title = 'All ' . Str::title($this->type) . 's';
        $this->layout->content = View::make('public.'.$this->current_theme.'.posts.index')
                                        ->with('posts', $posts)
                                        ->with('type', $this->type);
    }

    /**
     * Display the specified post.
     *
     * @param  int  $permalink
     * @return Response
     */
    public function show($permalink)
    {
        $post = Post::wherePermalink($permalink)->first();

        if (!$post) App::abort('404');

        $post->hits += 1;
        $post->save();
        $post->extras = json_decode($post->extras, true);

        if (isset($post->extras['contact_page']) && $post->extras['contact_page']) {
            $view = 'public.'.$this->current_theme.'.contact';
        } else {
            $view = 'public.'.$this->current_theme.'.posts.show';
        }

        $this->layout->title = $post->title;
        $this->layout->content = View::make($view)
                                        ->with('post', $post)
                                        ->with('type', $this->type);
    }

    public function category($alias)
    {
        $category = Category::where('alias', $alias)->first();

        $posts = $category->posts()->type($this->type)->target('public')->published()->recent()->paginate(5);

        $this->layout->title = 'All Posts in ' . $category->name;
        $this->layout->content = View::make('public.'.$this->current_theme.'.posts.index')
                                        ->with('posts', $posts)
                                        ->with('type', $this->type)
                                        ->with('category', $category);
    }

}
