<?php

namespace Kregel\Flight\Tests\Features;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Kregel\Flight\Tests\TestCase;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Laravel\Socialite\Two\User;

class FlightLoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $kernel = app('Illuminate\Contracts\Http\Kernel');
        $kernel->pushMiddleware('Illuminate\Session\Middleware\StartSession');
    }

    public function testWeCanGetTheFlightLoginPage()
    {
        $this->get(route('flight.login'))
            ->assertStatus(302);
    }

    public function testWeCanGetTheFlightCallbackPage()
    {
        Socialite::shouldReceive('driver')->once()->andReturnSelf();
        Socialite::shouldReceive('stateless')->once()->andReturnSelf();
        Socialite::shouldReceive('user')->once()->andReturn((new User)->map([
            'id' => 1,
            'nickname' => 'ghost',
            'name' => 'John Smith',
            'email' => 'email@fake.tools',
        ]));

        config()->set('laravel-flight.user_model', \Kregel\Flight\Tests\User::class);

        $response = $this->get(route('flight.callback'));
        $response->assertStatus(302);
        $response->assertRedirect(config('laravel-flight.post_login_redirect'));
    }

    public function testWeCanGetTheFlightCallbackAuthenticatesExistingUser()
    {
        Socialite::shouldReceive('driver')
            ->once()
            ->with('github')
            ->andReturnSelf();
        Socialite::shouldReceive('stateless')->once()->andReturnSelf();
        Socialite::shouldReceive('user')
            ->once()
            ->andReturn((new User)->map([
                'id' => 1,
                'nickname' => 'ghost',
                'name' => 'John Smith',
                'email' => 'email@fake.tools',
            ]));

        config()->set('laravel-flight.user_model', \Kregel\Flight\Tests\User::class);
        config()->set('laravel-flight.driver', 'github');

        $user = \Kregel\Flight\Tests\User::create([
            'name' => 'John Smith',
            'email' => 'email@fake.tools',
        ]);

        DB::table('social_logins')->insert([
            'service_id' => 1,
            'user_id' => $user->id,
            'driver' => 'github',
        ]);

        $response = $this->get(route('flight.callback'));
        $response->assertStatus(302);
        $response->assertRedirect(config('laravel-flight.post_login_redirect'));
    }

    public function testInvalidStateException()
    {
        Socialite::shouldReceive('driver')->once()->andReturnSelf();
        Socialite::shouldReceive('stateless')->once()->andReturnSelf();
        Socialite::shouldReceive('user')
            ->once()
            ->andThrow(new InvalidStateException('This is an invalid state exception.'));

        config()->set('laravel-flight.user_model', \Kregel\Flight\Tests\User::class);

        $response = $this->get(route('flight.callback'));
        $response->assertStatus(302);
        $response->assertRedirect(route('flight.login'));
    }
}
