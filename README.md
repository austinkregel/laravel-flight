# Stop dealing with the basic setup from Socialite.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kregel/laravel-flight.svg?style=flat-square)](https://packagist.org/packages/kregel/laravel-flight)
[![Total Downloads](https://img.shields.io/packagist/dt/kregel/laravel-flight.svg?style=flat-square)](https://packagist.org/packages/kregel/laravel-flight)

This package is meant to provide the most basic authentication setup with Laravel Socialite.
Stop dealing with setting up a /login redirect and /callback. Not all apps need their own auth system.
Sometimes we just want to login with an existing platform like Github, Auth0, or even a custom Laravel Passport instance.
While this still does have it's own user's table, it's largely used for tracking social users.


### Ok but why?
Because there are Laravel tools out there that don't come with authentication, but require it to be able to secure them for production access.


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

Add their ExtendSocialite event to our config file.

## Usage
The whole point of this is to drastically decrease the time to deploy for integrating a very basic OAuth client

To add support for different OAuth clients, you'll need to add
```php
// Usage description here
```

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
