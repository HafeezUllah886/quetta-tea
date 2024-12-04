<?php

use App\Http\Controllers\IssueVouchareController;
use App\Http\Controllers\SalesController;
use App\Http\Middleware\AdminStorekeeperCheck;
use App\Http\Middleware\confirmPassword;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

Route::get("sales/getproduct/{id}", [SalesController::class, 'getSignleProduct']);
Route::resource('issuevauchar', IssueVouchareController::class)->middleware(AdminStorekeeperCheck::class);
Route::get("issuevauchars/delete/{id}", [IssueVouchareController::class, 'destroy'])->name('vouchars.delete')->middleware(confirmPassword::class);
});


