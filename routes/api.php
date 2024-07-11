<?php

use App\Http\Controllers\WebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('pessoas', function() {
    try {
        $file = file_get_contents(public_path('/seeders/customers.json'));

        sleep(rand(2, 5));

        return response()->json(json_decode($file, true));
    } catch (\Throwable $th) {
        return response()->json(['error' => $th->getMessage()], 500);
    }
});

Route::get('pedidos', function() {
    try {
        $file = file_get_contents(public_path('/seeders/orders.json'));

        sleep(rand(2, 5));

        return response()->json(json_decode($file, true));
    } catch (\Throwable $th) {
        return response()->json(['error' => $th->getMessage()], 500);
    }
});

Route::get('pessoas', function() {
    try {
        $file = file_get_contents(public_path('/seeders/invoices.json'));

        sleep(rand(2, 5));

        return response()->json(json_decode($file, true));
    } catch (\Throwable $th) {
        return response()->json(['error' => $th->getMessage()], 500);
    }
});