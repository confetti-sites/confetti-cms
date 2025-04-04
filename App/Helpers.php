<?php

namespace App;

class Helpers
{
    public static function devTools(): bool
    {
        return config('environment.options.dev_tools') && request()->cookie("access_token");
    }
}