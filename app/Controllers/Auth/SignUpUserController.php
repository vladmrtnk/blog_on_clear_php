<?php

namespace App\Controllers\Auth;

use App\Components\Flash;
use App\Components\FormData;
use App\Controllers\BaseController;
use App\Models\User;
use App\Requests\Auth\SignUpRequest;

class SignUpUserController extends BaseController
{
    /**
     * Display the registration form view
     *
     * @return mixed
     */
    public function index()
    {
        return require_once APP_ROOT . '/views/auth/sign_up.php';
    }

    /**
     * Get data from authentication form and authorise
     *
     * @return void
     */
    public function store()
    {
        $validated = SignUpRequest::validated($_POST);

        if (array_search(false, $validated)) {
            if (!$validated['name']) {
                Flash::createMessage(INVALID_NAME, 'Enter the correct name. Min: 4 symbols', FLASH_ERROR);
            }

            if (!$validated['email']) {
                Flash::createMessage(INVALID_EMAIL, 'Enter the correct email. Or this email already exist',
                    FLASH_ERROR);
            }

            if (!$validated['password']) {
                Flash::createMessage(INVALID_PASSWORDS, 'Enter the correct password. Min: 6 symbols', FLASH_ERROR);
            }
            FormData::setOldData($_POST);
            header('Location: /sign-up');
            exit;
        }

        $user = new User($validated);
        if ($user->save()) {
            $_SESSION[AUTHENTICATED_USER] = $user->id;
            header('Location: /dashboard/posts');
        }
    }
}