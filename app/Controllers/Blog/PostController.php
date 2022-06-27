<?php

namespace App\Controllers\Blog;

use App\Controllers\BaseController;

class PostController extends BaseController
{
    /**
     * @return void
     */
    public function index()
    {
        require_once APP_ROOT . '/views/blog/posts.php';
    }
}