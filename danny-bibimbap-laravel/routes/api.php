<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\OrderController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/menu', [MenuController::class, 'index']);

Route::post('/order', [OrderController::class, 'store']);