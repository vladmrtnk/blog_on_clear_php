<?php

namespace App\Controllers\Blog;

use App\Controllers\BaseController;
use App\Models\Post;

class PostController extends BaseController
{
    /**
     * @return void
     */
    public function index()
    {
        $posts = Post::getAll();

        require_once APP_ROOT . '/views/blog/posts/index.php';
    }

    /**
     * @param  int  $id
     *
     * @return void|null
     */
    public function show(int $id)
    {
        $post = Post::find($id);

        require_once APP_ROOT . '/views/blog/posts/show.php';
    }
}