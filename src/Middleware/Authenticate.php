<?php

namespace Kregel\Flight\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        return $request->expectsJson() ? null : route('flight.login');
    }
}
