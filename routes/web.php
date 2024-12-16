<?php

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
});

// Route::middleware(['auth', 'role:Super Admin|Customer Default|Customer Admin'])->group(function () {
//     Route::view('profile', 'common.profile')
//         ->name('common.profile');
// });

Route::get('api/pessoas', [TestController::class, 'customers']);
Route::get('api/pedidos', [TestController::class, 'orders']);
Route::get('api/contas', [TestController::class, 'invoices']);

Route::get('teste', function() {
    $userCustomer = App\Models\User::where('type', 3)->whereNull('last_login_at')->where('active', false)->first();
    $userCustomerAdmin = App\Models\User::where('type', 2)->whereNull('last_login_at')->where('active', false)->first();

    $userCustomer ? $userCustomer->notify(new App\Notifications\NewUserNotification($userCustomer)) : null;
    $userCustomerAdmin ? $userCustomerAdmin->notify(new App\Notifications\NewUserNotification($userCustomerAdmin)) : null;
    return 'Ok!';
});

require __DIR__.'/auth.php';
