<?php

namespace Kregel\Flight\Controllers;

use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Laravel\Socialite\Two\User;

class CallbackController
{
    public function __invoke()
    {
        $userModel = config('laravel-flight.user_model');
        $driver = config('laravel-flight.driver');
        try {
            /** @var User $user */
            $user = Socialite::driver($driver)
                ->stateless(config('laravel-flight.stateless'))
                ->user();

            $socialiteUser = DB::table('social_logins')
                ->where('service_id', $user->id)
                ->where('driver', $driver)
                ->first();

            if (empty($socialiteUser)) {
                // So the goal of this is to be the primary auth solution. So let's assume anyone who can
                // visit the website, should be allowed to register unless explicitly disabled.
                abort_unless(
                    // this should abort only when registration is disabled.
                    config('laravel-flight.registration'),
                    404
                );

                $localUser = $userModel::firstWhere('email', $user->email);

                if (empty($localUser)) {
                    $localUser = $userModel::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'password' => 'unused',
                    ]);
                    DB::table('social_logins')
                        ->insert([
                            'user_id' => $localUser->id,
                            'service_id' => $user->id,
                            'driver' => $driver,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                }
            } else {
                $localUser = $userModel::firstWhere('id', $socialiteUser->user_id);
            }

            auth()->login($localUser);

            return redirect(config('laravel-flight.post_login_redirect'));
        } catch (InvalidStateException $exception) {
            return redirect(route('flight.login'));
        }
    }
}
