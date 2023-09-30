<?php

return [
    'prefix' => env('FLIGHT_URL_PREFIX', '/flight'),
    'login_redirect' => env('FLIGHT_LOGIN', '/login'),

    /**
     * The driver is the default authentication provider when visiting /login
     */
    'driver' => env('FLIGHT_DRIVER', 'github'),
    'user_model' => App\Models\User::class,

    /**
     * Disabling registration will not impact logging in. Those who have already logged in
     * can still do so by visiting the login url.
     */
    'registration' => env('FLIGHT_ALLOW_REGISTRATION', true),
    'post_login_redirect' => env('FLIGHT_LOGIN_REDIRECT', '/horizon'),
    'community_drivers' => [
        SocialiteProviders\LaravelPassport\LaravelPassportExtendSocialite::class,
    ],
    'stateless' => true,
    'scopes' => ['email', 'profile'],
    'middleware' => ['web'],
];
