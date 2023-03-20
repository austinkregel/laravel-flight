<?php

namespace Kregel\Flight\Controllers;

use Laravel\Socialite\Facades\Socialite;

class LoginController
{
    public function __invoke()
    {
        return Socialite::driver(config('laravel-flight.driver'))
            ->scopes(config('laravel-flight.scopes'))
            ->redirect();
    }
}
