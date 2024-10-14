<?php

use Illuminate\Support\Facades\Route; 
use Jmrashed\PurchaseKeyGuard\Http\Controllers\PurchaseKeyController;

// Prefix for purchase key related routes
Route::prefix('purchase-key')->group(function () {

    // Route for showing the purchase validation form
    Route::get('/validate', [PurchaseKeyController::class, 'showValidationForm'])
        ->name('purchase-key.validate.form');

    // Route for handling purchase validation submission
    Route::post('/validate', [PurchaseKeyController::class, 'validatePurchase'])
        ->name('purchase-key.validate.submit');

    // Route for showing the installation status
    Route::get('/status', [PurchaseKeyController::class, 'showStatus'])
        ->name('purchase-key.status');

    // Route for manual revalidation of purchase code
    Route::post('/revalidate', [PurchaseKeyController::class, 'revalidatePurchase'])
        ->name('purchase-key.revalidate.submit');

    // Route for viewing logs
    Route::get('/logs', [PurchaseKeyController::class, 'viewLogs'])
        ->name('purchase-key.logs');

    // Route for showing the installation form
    Route::get('/install', [PurchaseKeyController::class, 'showInstallForm'])
        ->name('purchase-key.install.form');

    // Route for handling installation process
    Route::post('/install', [PurchaseKeyController::class, 'install'])
        ->name('purchase-key.install.submit');
});
