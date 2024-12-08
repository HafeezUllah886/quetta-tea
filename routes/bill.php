<?php

use App\Http\Controllers\BillsController;
use App\Http\Middleware\cashierCheck;
use Illuminate\Support\Facades\Route;

Route::middleware('auth', cashierCheck::class)->group(function () {

    Route::resource('bills', BillsController::class);
    Route::get('bill/allitems', [BillsController::class, 'allItems']);
    Route::get('bill/bycategory/{id}', [BillsController::class, 'bycategory']);
    Route::get('bill/addtocart', [BillsController::class, 'addtocart']);
});
