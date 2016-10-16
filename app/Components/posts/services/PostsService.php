<?php namespace Components\Posts\Services;

use Category;
use Post;

/**
* Services related to posts and post categories
*/
class PostsService
{
    /**
     * Get recent posts
     * @param  string  $type [description]
     * @param  integer $qty  [description]
     * @return Object
     */
    public function getRecent($type='post', $qty=10)
    {
        return Post::type($type)->target('public')->published()->latest()->take($qty)->get();
    }

    /**
     * Get recent categories
     * @param  string $type
     * @return Object
     */
    public function getCategories($type='post')
    {
        return Category::type($type)->published()->latest()->get();
    }

    /**
     * Get recent featured post for a category
     * @param  integer $category_id [description]
     * @return Object
     */
    public function getFeaturedPost($category_id)
    {
        $category = Category::find($category_id);

        $latest_featured = $category->posts()->featured()->latest()->first();

        return $latest_featured;
    }
}
