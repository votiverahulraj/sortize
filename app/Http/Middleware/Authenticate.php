<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if ($request->expectsJson()) {
            return;
        }

        if ($request->is('admin') || $request->is('admin/*')) {
            return route('admin.login');
        }

        return route('admin.login'); // or any other route name for user login
    }
}
