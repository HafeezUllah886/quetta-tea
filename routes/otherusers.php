<?php

use App\Http\Controllers\OtherusersController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('otherusers/{type}', [OtherusersController::class, 'index'])->name('otherusers.index');
    Route::post('otherusers/store/{type}', [OtherusersController::class, 'store'])->name('otherusers.store');
    Route::patch('otherusers/update/{id}', [OtherusersController::class, 'update'])->name('otherusers.update');

    Route::get('otherusers/statement/{id}/{from}/{to}', [OtherusersController::class, 'show'])->name('userStatement');
});
