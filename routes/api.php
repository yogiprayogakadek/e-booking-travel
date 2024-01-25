<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Customer')
    ->controller(CartController::class)
    ->group(function() {
    Route::post('/payment/callback', 'callback')->name('payment.callback');
});


// Route::post('/payment/callback', [CartController::class, 'callback'])->name('callback');
