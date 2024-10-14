<?php

use Illuminate\Support\Facades\Route;
use Jmrashed\PurchaseKeyGuard\Http\Controllers\PurchaseKeyController;

// API routes for purchase key operations
Route::prefix('purchase-keys')->group(function () {
    Route::post('/', [PurchaseKeyController::class, 'create'])->name('purchase-keys.create');
    Route::get('/{key}', [PurchaseKeyController::class, 'show'])->name('purchase-keys.show');
    Route::put('/{key}', [PurchaseKeyController::class, 'update'])->name('purchase-keys.update');
    Route::delete('/{key}', [PurchaseKeyController::class, 'destroy'])->name('purchase-keys.destroy');
    Route::post('/validate', [PurchaseKeyController::class, 'validateKey'])->name('purchase-keys.validate');
});
