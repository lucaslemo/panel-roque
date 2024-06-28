<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', 'login')->name('home');

Route::middleware(['auth', 'role:Super Admin'])->group(function () {
    Route::view('admin/dashboard', 'admin.dashboard')
        ->name('admin.dashboard');

    Route::view('admin/users', 'admin.users')
        ->name('admin.users');
});

Route::middleware(['auth', 'role:Customer'])->group(function () {
    Route::view('dashboard', 'app.dashboard')
        ->name('app.dashboard');
    Route::view('requests', 'app.requests')
        ->name('app.requests');
    Route::view('financial', 'app.financial')
        ->name('app.financial');
    Route::view('creditLimit', 'app.creditLimits')
        ->name('app.creditLimits');
});

Route::middleware(['auth', 'role:Super Admin|Customer'])->group(function () {
    Route::view('profile', 'common.profile')
        ->name('common.profile');
});

require __DIR__.'/auth.php';
