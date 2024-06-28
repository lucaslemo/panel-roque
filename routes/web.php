<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::redirect('/', 'login')->name('home');

Route::middleware(['auth', 'role:Super Admin'])->group(function () {
    Volt::route('admin/dashboard', 'pages.admin.dashboard')
        ->name('admin.dashboard');

    Volt::route('admin/users', 'pages.admin.users')
        ->name('admin.users');
});

Route::middleware(['auth', 'role:Customer'])->group(function () {
    Volt::route('dashboard', 'pages.app.dashboard')
        ->name('app.dashboard');
    Volt::route('requests', 'pages.app.requests')
        ->name('app.requests');
    Volt::route('financial', 'pages.app.financial')
        ->name('app.financial');
    Volt::route('creditLimit', 'pages.app.creditLimits')
        ->name('app.creditLimits');
});

Route::middleware(['auth', 'role:Super Admin|Customer'])->group(function () {
    Volt::route('profile', 'pages.common.profile')
        ->name('common.profile');
});

require __DIR__.'/auth.php';
