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
use Robbo\Presenter\Presenter;

class PostPresenter extends Presenter
{
    /**
     * Get the page's excerpt
     * @return string
     */
    public function excerpt($length=80)
    {
        if (strpos($this->content, '<!--more-->')) {
            list($excerpt, $more) = explode('<!--more-->', $this->content);
            return Services\String::tidy($excerpt);
        } else {
            return Services\String::tidy(Str::limit($this->content, $length));
        }
    }

    /**
     * Get the creation date of the page
     * @return string
     */
    public function date()
    {
        return $this->created_at->format('d') . '<br>' . $this->created_at->format('M') . '<br>' . $this->created_at->format('Y');
    }

    /**
     * Get all the categories that a post lies in
     * @return string
     */
    public function selected_categories($field='id')
    {
        $ret = array();
        foreach ($this->categories as $category) {
            $ret[] = $category->{$field};
        }
        return $ret;
    }

    /**
     * Get the page's status
     * @return string
     */
    public function status()
    {
        return Str::title($this->status);
    }

    /**
     * Get the page's author
     * @return string
     */
    public function author()
    {
        try {
            $user = Sentry::findUserById($this->created_by);
            return $user->username;
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return '';
        }
    }

    /**
     * Get the page's editor
     * @return string
     */
    public function editor()
    {
        if ($this->updated_by == null) {
            return '';
        }
        try {
            $user = Sentry::findUserById($this->updated_by);
            return $user->username;
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return '';
        }
    }
}
