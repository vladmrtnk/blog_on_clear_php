<?php

namespace App\Requests\Auth;

use App\Models\User;
use App\Requests\Request;

class SignUpRequest extends Request
{
    /**
     * @param  array  $data
     *
     * @return array
     */
    public static function validated(array $data):array
    {
        $result = filter_var_array($data, [
            'name'     => [
                'filter'  => FILTER_VALIDATE_REGEXP,
                'options' => [
                    'regexp' => '/^.{4,25}$/',
                ],
            ],
            'email'    => FILTER_VALIDATE_EMAIL,
            'password' => [
                'filter'  => FILTER_VALIDATE_REGEXP,
                'options' => [
                    'regexp' => '/^.{6,50}$/',
                ],
            ],
        ]);

        if ($data['password'] != $data['second_password']) {
            $result['password'] = false;
        }

        if ($result['email']) {
            if (User::exist($result['email'])) {
                $result['email'] = false;
            }
        }

        return $result;
    }
}