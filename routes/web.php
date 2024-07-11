<?php

use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'login')->name('home');

Route::middleware(['auth', 'role:Super Admin'])->group(function () {
    Route::view('admin/dashboard', 'admin.dashboard')
        ->name('admin.dashboard');

    Route::view('admin/users', 'admin.users.index')
        ->name('admin.users');
    Route::view('admin/users/{id}/edit', 'admin.users.edit')
        ->name('admin.users.edit');

    Route::view('admin/customers', 'admin.customers.index')
        ->name('admin.customers');
    Route::view('admin/customers/{id}/edit', 'admin.customers.edit')
        ->name('admin.customers.edit');
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
