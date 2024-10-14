<?php

use Illuminate\Support\Facades\Route; 
use Jmrashed\PurchaseKeyGuard\Http\Controllers\PurchaseKeyController;

// Route for showing the purchase validation form
Route::get('/purchase/validate', [PurchaseKeyController::class, 'showValidationForm'])
    ->name('purchase.validate');

// Route for handling purchase validation submission
Route::post('/purchase/validate', [PurchaseKeyController::class, 'validatePurchase'])
    ->name('purchase.validate.submit');

// Route for showing the installation status
Route::get('/purchase/status', [PurchaseKeyController::class, 'showStatus'])
    ->name('purchase.status');

// Route for manual revalidation of purchase code
Route::post('/purchase/revalidate', [PurchaseKeyController::class, 'revalidatePurchase'])
    ->name('purchase.revalidate');

// Route for viewing logs
Route::get('/purchase/logs', [PurchaseKeyController::class, 'viewLogs'])
    ->name('purchase.logs');

// Route for installation of the package
Route::get('/purchase/install', [PurchaseKeyController::class, 'showInstallation'])
    ->name('purchase.install');

// Route for handling installation process
Route::post('/purchase/install', [PurchaseKeyController::class, 'handleInstallation'])
    ->name('purchase.install.submit');
