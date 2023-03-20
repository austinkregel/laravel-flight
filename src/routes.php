<?php

use Illuminate\Support\Facades\Route;

Route::get(
    config('laravel-flight.prefix').'/login',
    Kregel\Flight\Controllers\LoginController::class
)->name('flight.login');

Route::get(
    config('laravel-flight.prefix').'/callback',
    Kregel\Flight\Controllers\CallbackController::class
)->name('flight.callback');
