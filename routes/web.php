<?php

use App\Http\Controllers\brandsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\RawMaterialController;
use App\Http\Controllers\UnitsController;
use App\Http\Middleware\adminCheck;
use Illuminate\Support\Facades\Route;


require __DIR__ . '/auth.php';
require __DIR__ . '/finance.php';
require __DIR__ . '/purchase.php';
require __DIR__ . '/stock.php';
require __DIR__ . '/sale.php';
require __DIR__ . '/reports.php';
require __DIR__ . '/otherusers.php';

Route::middleware('auth')->group(function () {

    Route::get('/', [dashboardController::class, 'index'])->name('dashboard');
    Route::resource('units', UnitsController::class)->middleware(adminCheck::class);
    Route::resource('categories', CategoriesController::class)->middleware(adminCheck::class);
    Route::resource('raw_material', RawMaterialController::class)->middleware(adminCheck::class);
    Route::resource('items', ItemsController::class)->middleware(adminCheck::class);
    Route::get('item/status/{id}', [ItemsController::class, 'status'])->name('item.status')->middleware(adminCheck::class);

});


