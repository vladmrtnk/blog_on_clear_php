<?php

namespace App\Requests;

use App\Models\Tag;

class TagStoreRequest extends Request
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
            if (strlen($data['title']) < 3 || strlen($data['title']) > 15) {
                $result['title'] = false;
            }
        } else {
            $result['title'] = false;
        }

        if ($result['title']) {
            $formatted = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $data['title'])));

            $result['title'] = $formatted;

            if (Tag::exist($formatted)) {
                $result['title'] = false;
            }
        }

        return $result;
    }
}