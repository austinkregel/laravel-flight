<?php

namespace Kregel\Flight\Tests;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Event;
use Kregel\Flight\FlightServiceProvider;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

class TestCase extends TestbenchTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('optimize:clear');
        config()->set('services.github', [
            'client_id' => 4820802,
            'client_secret' => 'asdfkjlli4j2oirj2lk4efakf',
            'redirect' => route('flight.callback')
        ]);

        /** @var Migration $migration */
        $migration = require __DIR__.'/migrations/2014_10_12_000000_create_users_table.php';
        $migration->up();
//        $social = require __DIR__.'/../database/migrations/2023_03_01_000000_create_social_logins_table.php';
//        $social->up();
    }

    protected function getPackageProviders($app)
    {
        return [
            \Laravel\Socialite\SocialiteServiceProvider::class,
            FlightServiceProvider::class,
        ];
    }
    protected function getApplicationAliases($app)
    {
        return [
            'Socialite' => \Laravel\Socialite\Facades\Socialite::class,
            'Event' => Event::class,
        ];
    }
}

