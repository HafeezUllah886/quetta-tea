<?php

use App\Http\Controllers\OtherusersController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('otherusers/{type}', [OtherusersController::class, 'index'])->name('otherusers.index');
    Route::get('otherusers/store/{type}', [OtherusersController::class, 'store'])->name('otherusers.store');
    Route::get('otherusers/update/{id}', [OtherusersController::class, 'update'])->name('otherusers.update');
});
