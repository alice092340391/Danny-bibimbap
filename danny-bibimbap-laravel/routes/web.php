<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth:staff'])->group(function () {
    Route::get('/manage', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/manage/orders', [OrderController::class, 'index'])->name('orders.index');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/order/{tableNumber}', function ($tableNumber) {
    return view('ordering.index', ['tableNumber' => $tableNumber]);
})->name('order.show');
