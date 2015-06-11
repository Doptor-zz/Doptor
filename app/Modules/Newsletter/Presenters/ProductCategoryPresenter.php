<?php namespace Modules\Newsletter\Presenters;

use Str;
use Robbo\Presenter\Presenter;

class ProductCategoryPresenter extends Presenter
{
    /**
     * Get the creation date of the page
     * @return string
     */
    public function date()
    {
        return $this->created_at->format('Y-m-d h:i:s');
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
     * Get the category's author
     * @return string
     */
    public function author()
    {
        return ($this->authorUser) ? $this->authorUser->username : 'User Deleted';
    }

    /**
     * Get the category's editor
     * @return string
     */
    public function editor()
    {
        if ($this->updated_by == null) {
            return '';
        }
        return ($this->editorUser) ? $this->editorUser->username : 'User Deleted';
    }
}
