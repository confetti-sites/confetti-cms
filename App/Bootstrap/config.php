<?php

/**
 * This array is loaded from the `app_config.json5` file.
 * You can access the configuration of the current environment and container.
 * The key `environments` is now `environment` and `containers` is now `container`.
 *
 * Examples:
 * You can get the name of the current environment with `config('environment.name')`.
 * You can get the option `dev_tools` of the current environment with `config('environment.options.dev_tools')`.
 * You can get the name of the current container with `config('environment.container.name')`.
 * You can get the hosts with `config('environment.container.hosts')`.
 *
 * Customize this function to suit your needs, but don't unset existing keys, as they might be used elsewhere.
 */
function config(string $key, mixed $default = null): mixed
{
    $config = $_ENV['APP_CONFIG'];

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

