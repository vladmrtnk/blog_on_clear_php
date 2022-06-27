<?php

namespace App\Controllers\Auth;

use App\Components\Flash;
use App\Components\FormData;
use App\Controllers\BaseController;
use App\Models\User;
use App\Requests\Auth\SignInRequest;

class SignInUserController extends BaseController
{
    /**
     * Display the authentication form view.
     *
     * @return mixed
     */
    public function index()
    {
        return require_once APP_ROOT . '/views/auth/sign_in.php';
    }

    /**
     * Get data from authentication form and authorise
     *
     * @return void
     */
    public function store()
    {
        session_start();
        $validated = SignInRequest::validated($_POST);

        if (!$validated['email']) {
            FormData::setOldData($_POST);
            Flash::createMessage(SIGN_IN_ERROR, 'Enter the correct email or password', FLASH_ERROR);

            header('Location: /login');
            exit;
        }

        $user = User::findById(1);

        if ($user->authenticate($_POST['password'])) {
            header('Location: /dashboard');
            exit;
        }
    }
}