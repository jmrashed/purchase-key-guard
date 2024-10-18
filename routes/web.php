<?php

use Illuminate\Support\Facades\Route;
use Jmrashed\PurchaseKeyGuard\Http\Controllers\PurchaseKeyController;

Route::prefix('purchase')->middleware('web')->group(function () {
    // Validate Route
    Route::get('/validate',    [PurchaseKeyController::class, 'showValidationForm'])->name('validate.form');
    Route::post('/validation', [PurchaseKeyController::class, 'validatePurchase'])->name('validate.submit');

    // Route for showing the installation status
    Route::get('/status/{code}', [PurchaseKeyController::class, 'showStatus'])->name('status');

    // Route for manual revalidation of purchase code
    Route::get('/revalidate/success', [PurchaseKeyController::class, 'success'])->name('validate.success');
    Route::get('/revalidate',         [PurchaseKeyController::class, 'revalidatePurchaseForm'])->name('revalidate.form');
    Route::post('/revalidate',        [PurchaseKeyController::class, 'revalidatePurchase'])->name('revalidate.submit');
});
