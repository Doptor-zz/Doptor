<?php namespace Components\Posts\Services;

use Post;

/**
*
*/
class PostsService
{
    public function getRecent($type='post', $qty=10)
    {
        return Post::type($type)->target('public')->published()->latest()->take($qty)->get();
    }
}