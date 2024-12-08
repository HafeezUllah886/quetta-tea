<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\RawCategoriesController;
use App\Http\Controllers\RawCategoryController;
use App\Http\Controllers\RawMaterialController;
use App\Http\Controllers\TablesController;
use App\Http\Controllers\UnitsController;
use App\Http\Middleware\adminCheck;
use App\Http\Middleware\AdminStorekeeperCheck;
use Illuminate\Support\Facades\Route;


require __DIR__ . '/auth.php';
require __DIR__ . '/finance.php';
require __DIR__ . '/purchase.php';
require __DIR__ . '/stock.php';
require __DIR__ . '/issuevauchar.php';
require __DIR__ . '/reports.php';
require __DIR__ . '/otherusers.php';
require __DIR__ . '/bill.php';

Route::middleware('auth')->group(function () {

    Route::get('/', [dashboardController::class, 'index'])->name('dashboard');
    Route::resource('units', UnitsController::class)->middleware(AdminStorekeeperCheck::class);
    Route::resource('tables', TablesController::class)->middleware(adminCheck::class);
    Route::resource('categories', CategoriesController::class)->middleware(adminCheck::class);
    Route::resource('rawcategories', RawCategoryController::class)->middleware(AdminStorekeeperCheck::class);
    Route::resource('raw_material', RawMaterialController::class)->middleware(AdminStorekeeperCheck::class);
    Route::get('get/raw_material/{id}', [RawMaterialController::class, 'getMaterial']);

    Route::resource('items', ItemsController::class)->middleware(adminCheck::class);
    Route::get('item/status/{id}', [ItemsController::class, 'status'])->name('item.status')->middleware(adminCheck::class);

});


