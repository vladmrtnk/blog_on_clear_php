<?php

namespace App\Components;

class FormData
{
    /**
     * Set old data from the contract form to $_SESSION
     *
     * @param  array  $data
     *
     * @return void
     */
    public static function setOldData(array $data)
    {
        if (isset($_SESSION[OLD_FORM_DATA])) {
            unset($_SESSION[OLD_FORM_DATA]);
        }
        $_SESSION[OLD_FORM_DATA] = $data;
    }

    /**
     * Get old data from the contract form from  $_SESSION
     *
     * @return string
     */
    public static function getOldData(string $needle)
    {
        if (!isset($_SESSION[OLD_FORM_DATA][$needle])) {
            return null;
        }

        $data = $_SESSION[OLD_FORM_DATA][$needle];
        unset($_SESSION[OLD_FORM_DATA][$needle]);

        return $data;
    }
}