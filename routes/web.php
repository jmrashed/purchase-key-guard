<?php

use Illuminate\Support\Facades\Route;
use Jmrashed\PurchaseKeyGuard\Http\Controllers\Admin\PurchaseKeyController as AdminPurchaseKeyController;
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

Route::prefix('admin/purchase-keys')->middleware('web')->group(function () {
    Route::get('/', [AdminPurchaseKeyController::class, 'index'])->name('admin.purchase-keys.index');
    Route::get('/create', [AdminPurchaseKeyController::class, 'create'])->name('admin.purchase-keys.create');
    Route::post('/', [AdminPurchaseKeyController::class, 'store'])->name('admin.purchase-keys.store');
    Route::get('/{purchaseKey}/edit', [AdminPurchaseKeyController::class, 'edit'])->name('admin.purchase-keys.edit');
    Route::put('/{purchaseKey}', [AdminPurchaseKeyController::class, 'update'])->name('admin.purchase-keys.update');
    Route::delete('/{purchaseKey}', [AdminPurchaseKeyController::class, 'destroy'])->name('admin.purchase-keys.destroy');
    Route::post('/{purchaseKey}/revoke', [AdminPurchaseKeyController::class, 'revoke'])->name('admin.purchase-keys.revoke');
});
