<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', 'login')->name('home');

Route::middleware(['auth', 'role:Super Admin'])->group(function () {
    Route::view('admin/dashboard', 'admin.dashboard')
        ->name('admin.dashboard');
    Route::view('admin/users', 'admin.users')
        ->name('admin.users');
    Route::view('admin/customers', 'admin.customers')
        ->name('admin.customers');
    Route::view('admin/users/{id}/edit', 'admin.edit')
        ->name('admin.users.edit');
});

Route::middleware(['auth', 'role:Customer'])->group(function () {
    Route::view('dashboard', 'app.dashboard')
        ->name('app.dashboard');
    Route::view('orders', 'app.orders')
        ->name('app.orders');
    Route::view('invoices', 'app.invoices')
        ->name('app.invoices');
    Route::view('creditLimits', 'app.creditLimits')
        ->name('app.creditLimits');
});

Route::middleware(['auth', 'role:Super Admin|Customer'])->group(function () {
    Route::view('profile', 'common.profile')
        ->name('common.profile');
});

require __DIR__.'/auth.php';
