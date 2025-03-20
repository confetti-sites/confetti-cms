<?php

/**
 * Here you can define your own config function.
 * This function is used to get values from the config array.
 * You can use dot notation to get nested values.
 * For example when you have the following config array:
 * [
 *    'homepage' => [
 *       'show_title' => true,
 *    ]
 * ]
 *
 * You can get the value of 'show_title' by calling config('homepage.show_title', false);
 *
 * Customize this function to suit your needs.
 * You can organize the configuration data into multiple files for better structure.
 */
function config(string $key, mixed $default = null): mixed
{
    $config = [
        /**
         * All these values are equal to the values in the app_config.json5 file.
         * At least, the following keys are available:
         * environment.name
         * environment.stage
         * environment.options.dev_tools
         */
        'environment' => $_ENV['ENV_CONFIG'],
    ];

    /**
     * This part is where the magic happens! It fetches the value from the config array.
     * Feel free to marvel at its simplicity or tweak it to your needs.
     */
    $parts = explode('.', $key);
    foreach ($parts as $part) {
        if (!isset($config[$part])) {
            return $default;
        }
        $config = $config[$part];
    }

    return $config;
}

