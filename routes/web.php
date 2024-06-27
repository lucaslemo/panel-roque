<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::redirect('/', 'admin/dashboard')
    ->middleware(['auth'])
    ->name('home');

Volt::route('admin/dashboard', 'pages.admin.dashboard')
    ->middleware(['auth'])
    ->name('admin.dashboard');

Volt::route('admin/users', 'pages.admin.users')
    ->middleware(['auth'])
    ->name('admin.users');

Volt::route('dashboard', 'pages.app.dashboard')
    ->middleware(['auth'])
    ->name('app.dashboard');

Volt::route('profile', 'pages.common.profile')
    ->middleware(['auth'])
    ->name('common.profile');

require __DIR__.'/auth.php';
