<?php namespace Modules\Newsletter\Presenters;

use Sentry;
use Robbo\Presenter\Presenter;
use Str;
use Modules\Helpers\String;

class ProductPresenter extends Presenter
{
    /**
     * Get the page's excerpt
     * @param int $length
     * @return string
     */
    public function excerpt($length = 80)
    {
        if (strpos($this->content, '<!--more-->')) {
            list($excerpt, $more) = explode('<!--more-->', $this->content);
            return String::tidy($excerpt);
        } else {
            return String::tidy(Str::limit($this->content, $length));
        }
    }

    /**
     * Get the language that the current page/post is in
     * @return string
     */
    public function language()
    {
        if ($this->language) {
            return $this->language->name;
        } else {
            return 'None';
        }
    }

    public function price()
    {
        return $this->price;
    }

    /**
     * Get all the categories that a post lies in
     * @param string $field
     * @return string
     */
    public function selected_categories($field = 'id')
    {
        $ret = array();
        foreach ($this->categories()->get() as $category) {
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
        return ($this->authorUser) ? $this->authorUser->username : 'User Deleted';
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
        return ($this->editorUser) ? $this->editorUser->username : 'User Deleted';
    }

    public function created_at()
    {
        return $this->created_at;
    }
}
