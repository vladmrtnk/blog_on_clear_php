<?php

namespace App\Requests;

class PostStoreRequest extends Request
{
    /**
     * @param  array  $data
     *
     * @return array
     */
    static function validated(array $data): array
    {
        $result = $data;

        /* Validation title */
        if (isset($data['title'])) {
            if (strlen($data['title']) < 4 || strlen($data['title']) > 50)
                $result['title'] = false;
        } else {
            $result['title'] = false;
        }

        /* Validation content */
        if (isset($data['content'])) {
            if (strlen($data['content']) < 50 || strlen($data['content']) > 10000)
                $result['content'] = false;
        } else {
            $result['content'] = false;
        }

        /* Validation image */
        if (isset($data['image']['name'])) {
            $validFormats = [
                'image/png',
                'image/jpeg',
                'image/img',
                'image/jpg',
            ];

            if (!in_array($data['image']['type'], $validFormats))
                $result['image'] = false;
        }

        return $result;
    }
}