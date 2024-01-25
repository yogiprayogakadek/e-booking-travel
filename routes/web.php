<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->namespace('Main')->group(function () {
    Route::controller(ErrorController::class)
        ->as('error.')
        ->group(function () {
            Route::get('/forbidden', 'forbidden')->name('forbidden');
            Route::get('/notfound', 'notfound')->name('notfound');
        });
});

Route::namespace('Main')->middleware('auth')->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::controller(DashboardController::class)->as('dashboard.')->prefix('dashboard')->group(function () {
        Route::get('/', 'index')->name('index');
        // Route::post('/chart-in-out-medicines', 'chartInOutMedicines')->name('chart.inout.medicines');
        // Route::post('/chart-in-out-by-category', 'pieChartInOutByCategory')->name('chart.inout.category');
    });

    Route::controller(CustomerController::class)
        ->middleware('checkRole:admin')
        ->as('customer.')
        ->prefix('customer')
        ->group(function () {
            Route::get('/', 'index')->name('index');
        });

    Route::controller(PackageController::class)
        ->middleware('checkRole:admin')
        ->as('package.')
        ->prefix('package')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
        });

    Route::controller(OrderController::class)
        ->middleware('checkRole:admin')
        ->prefix('order')
        ->as('order.')
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('/detail/{order_id}', 'detail')->name('detail');
            Route::post('/print', 'print')->name('print');
        });
});

Route::namespace('Customer')->prefix('customer')->as('customer.')->middleware(['auth', 'checkRole:customer'])->group(function () {
    Route::controller(PackageController::class)
        ->as('package.')
        ->prefix('package')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
        });

    Route::controller(CartController::class)
        ->prefix('cart')
        ->as('cart.')
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('/render', 'render')->name('render');
            Route::post('/update', 'update')->name('update');
            Route::post('/payment', 'payment')->name('payment');
            Route::post('/payment-checking', 'paymentChecking')->name('payment.checking');
        });

    Route::controller(OrderController::class)
        ->prefix('order')
        ->as('order.')
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('/detail/{order_id}', 'detail')->name('detail');
        });
});

Route::namespace('Main')->middleware('guest')->group(function() {
    Route::controller(RegisterController::class)
            ->prefix('register')
            ->as('register.')
            ->group(function() {
                Route::get('/main', 'index')->name('main');
                Route::post('/store', 'store')->name('store');
            });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
