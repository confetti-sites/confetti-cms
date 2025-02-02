<?php

declare(strict_types=1);

namespace App\Http\Routes;

use App\Http\Entity\View;

class Website
{
    public static function canRender(): bool
    {
        return true;
    }

    public static function render(): View
    {
        return match (true) {
            request()->uri() === '/'                       => new View('website.homepage'),
            request()->uri() === '/waiting-list'           => new View('website.waitlist'),
            request()->uri() === '/waiting-callback'       => new View('website.waitlist_callback'),
            request()->uri() === '/auth/callback'          => new View('website.includes.auth.callback'),
            request()->uri() === '/waiting-list-step-1'    => new View('website.waiting-list-step-1'),
            request()->uri() === '/waiting-list-step-2'    => new View('website.waiting-list-step-2'),
            request()->uri() === '/pricing'                => new View('website.pricing'),
            str_starts_with(request()->uri(), '/docs')     => new View('website.docs'),
            str_starts_with(request()->uri(), '/features') => new View('website.features'),
            default                                        => new View('website.404'),
        };
    }
}