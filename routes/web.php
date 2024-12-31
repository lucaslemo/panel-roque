<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\InstagramController;
use App\Http\Controllers\TestController;
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

Route::middleware(['auth', 'role:Customer Default|Customer Admin'])->group(function () {
    Route::view('dashboard', 'app.dashboard')
        ->name('app.dashboard');

    Route::view('orders', 'app.orders')
        ->name('app.orders');

    Route::view('invoices', 'app.invoices')
        ->name('app.invoices');

    Route::view('history', 'app.invoicesHistory')
        ->name('app.invoicesHistory');

    Route::view('creditLimits', 'app.creditLimits')
        ->name('app.creditLimits');
});

Route::middleware(['auth'])->group(function () {
    Route::get('instagram/latestImages', [InstagramController::class, 'getLatestImages'])
        ->name('app.instagramLatestImages');

    Route::get('file/xml/{id}', [FileController::class, 'xml'])
        ->name('app.xml');

    Route::get('file/nfe/{id}', [FileController::class, 'nfe'])
        ->name('app.nfe');

    Route::get('file/ticket/{id}', [FileController::class, 'ticket'])
        ->name('app.ticket');

    Route::get('file/details/{id}', [FileController::class, 'details'])
        ->name('app.details');
});

require __DIR__.'/auth.php';
