<?php

namespace App\Controllers\Blog;

use App\Controllers\BaseController;

class HomeController extends BaseController
{
    /**
     * @return void
     */
    public function index()
    {
        require_once APP_ROOT . '/views/blog/index.php';
    }
}