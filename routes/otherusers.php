<?php

use App\Http\Controllers\OtherusersController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('otherusers/{type}', [OtherusersController::class, 'index'])->name('otherusers.index');
});
