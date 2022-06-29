<?php

namespace App\Requests\Auth;

use App\Models\User;
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

        if ($result['email']) {
            if (!User::exist($result['email'])) {
                $result['email'] = false;
            }
        }

        return $result;
    }
}