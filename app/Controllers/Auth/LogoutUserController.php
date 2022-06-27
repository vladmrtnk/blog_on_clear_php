<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;

class LogoutUserController extends BaseController
{
    /**
     * @return void
     */
    public function index()
    {
        session_start();

        $_SESSION[AUTHENTICATED_USER] = false;

        header('Location: /sign-in');
    }
}