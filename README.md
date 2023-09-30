# Stop publishing apps with public horizon access.

Secure your apps easily with Laravel Socialite and OAuth. Install this package, configure a few env values, a config/services.php entry, and then login. Never leave your apps unprotected.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kregel/laravel-flight.svg?style=flat-square)](https://packagist.org/packages/kregel/laravel-flight)
[![Total Downloads](https://img.shields.io/packagist/dt/kregel/laravel-flight.svg?style=flat-square)](https://packagist.org/packages/kregel/laravel-flight)

Streamline your Authentication even further. Integrate with your own internal Laravel Passport instance and enable your users to login however they need to.

Stop dealing with setting up a /login redirect and /callback. Not all apps need their own auth system.
Sometimes we just want to login with an existing platform like Github, Auth0, or even a custom Laravel Passport instance.
While this still does have it's own user's table, it's largely used for tracking social users.


### Ok but why?
Because there are Laravel tools out there that don't come with authentication, but require it to be able to secure them for production access.

This package let's you grab your favorite Github, Google, or other supported OAuth provider's credentials, set them in your env, visit `http://yoururl/flight/login` and login. You should be redirected to the auth provider you chose as your `FLIGHT_DRIVER`, and you will then be redirected to `FLIGHT_LOGIN_REDIRECT`.

Users that don't exist at the time of the request will be created unless you explicitly disable registration with an env var (so turn it off after you registery) `FLIGHT_ALLOW_REGISTRATION`

## Installation

You can install the package via composer:

```bash
composer require kregel/laravel-flight
```

Publish the config

```
php artisan vendor:publish --provider=Kregel\\Flight\\FlightServiceProvider
```
Find a [socialite provider](https://socialiteproviders.com/about/) you wish to use

Add their ExtendSocialite event to our config file under the `community_drivers` section, and if you wish to make it your primary driver, set your `FLIGHT_DRIVER`

## Post setup
You'll want to verify that you have your  `web` middleware configured. And you'll want the `auth` middleware too, so Laravel will redirect you to your auth provider.

If you're reading a headless type of system and have removed those middlewares here's basically the same stuff.

In your `app/Http/Kernel.php` the `web` middleware would basically be 
```php
    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToke::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];
```

And under the `$middlewareAliases` portion you can add the following replacement for `App\Http\Middleware\Authenticate`

```php
'auth' => \Kregel\Flight\Middleware\Authenticate::class,
'guest' => \Kregel\Flight\Middleware\RedirectIfAuthenticated::class,
```
Both of the above middleware are almost directly taken from the base Laravel app, with minor adjustments for configuration.

## Integrating new socialite providers
To add a new authentication provider to your app, you'll need to `composer require` their package into your app,
then add their ExtendSocialite listener to the `community_drivers` page. Once the driver has been added, you'll need
to open your `config/services.php` file and add the following equivalent for your driver
. Replacing `driver_name` and `DRIVER_NAME` with your actual driver.
```php
'driver_name' => [
    'client_id' => env('DRIVER_NAME_CLIENT_ID'),
    'client_secret' => env('DRIVER_NAME_CLIENT_SECRET'),
    'redirect' => env('DRIVER_NAME_REDIRECT_URI'),
],
```

If your preferred driver is github, then it'll look like this:
```php
'github' => [
    'client_id' => env('GITHUB_CLIENT_ID'),
    'client_secret' => env('GITHUB_CLIENT_SECRET'),
    'redirect' => env('GITHUB_REDIRECT'),
],
```

Lastly, change your `FLIGHT_DRIVER` env var to your preferred driver.

And visit `http://yourwebsite/flight/login`

If you haven't already set up the redirect url or callback url  `http://yourwebsite/flight/callback`

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email 5355937+austinkregel@users.noreply.github.com instead of using the issue tracker.

## Credits

-   [Austin Kregel](https://github.com/kregel)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
