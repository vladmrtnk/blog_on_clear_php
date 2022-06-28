<?php

namespace App\Components;

class Flash
{
    /**
     * Create a flash message
     *
     * @param  string  $name
     * @param  string  $message
     * @param  string  $type
     *
     * @return void
     */
    public static function createMessage(string $name, string $message, string $type)
    {
        if (isset($_SESSION[FLASH][$name])) {
            unset($_SESSION[FLASH][$name]);
        }

        $_SESSION[FLASH][$name] = ['message' => $message, 'type' => $type];
    }

    /**
     * Format a flash message
     *
     * @param  array  $flash_message
     *
     * @return string
     */
    private static function formatMessage(array $flash_message): string
    {
        return sprintf('<div class="invalid-feedback alert-%s">%s</div>',
            $flash_message['type'],
            $flash_message['message']
        );
    }

    /**
     * Display a flash message
     *
     * @param  string  $name
     *
     * @return string
     */
    public static function displayMessage(string $name)
    {
        if (!isset($_SESSION[FLASH][$name])) {
            return null;
        }

        $flash_message = $_SESSION[FLASH][$name];

        unset($_SESSION[FLASH][$name]);

        return self::formatMessage($flash_message);
    }

    /**
     * Check for any errors
     *
     * @param  string|null  $nameError
     *
     * @return bool
     */
    public static function hasErrors(string $nameError = null): bool
    {
        if (!isset($_SESSION[FLASH]))
            return false;

        if (isset($nameError)){
            return array_key_exists($nameError, $_SESSION[FLASH]);
        }

        foreach ($_SESSION[FLASH] as $message) {
            if ($message['type'] == FLASH_ERROR) {
                return true;
            }
        }

        return false;
    }
}