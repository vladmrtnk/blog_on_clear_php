<?php

namespace App\Requests\Auth;

use App\Requests\Request;

class SignInRequest extends Request
{
    /**
     * @param  array  $data
     *
     * @return mixed
     */
    public static function validated(array $data): array
    {
        $result = filter_var_array($data, [
            'email' => FILTER_VALIDATE_EMAIL,
        ]);

        return $result;
    }
}