<?php

declare(strict_types=1);

namespace App\Http\Routes;

use App\Http\Entity\View;

/**
 * Here you define your admin routes.
 * Feel free to modify this class to suit your needs
 *
 * Other routes to match?
 * Create a new class and register it in App/Bootstrap/Bootstrap.php
 */
class Admin
{
    public static function canRender(): bool
    {
        // Match /admin and /admin/*, but not /admin_frontend
        return request()->uri() === '/admin' || str_starts_with(request()->uri(), '/admin/');
    }

    public static function render(): View
    {
        return new View('admin.index');
    }
}