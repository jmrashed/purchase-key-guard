<?php

namespace Jmrashed\PurchaseKeyGuard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Jmrashed\PurchaseKeyGuard\Services\PurchaseKeyService;
use Jmrashed\PurchaseKeyGuard\Exceptions\PurchaseKeyStoreException;
use Jmrashed\PurchaseKeyGuard\Http\Requests\PurchaseKeyStoreRequest;
use Jmrashed\PurchaseKeyGuard\Http\Requests\PurchaseRevalidationRequest;

class PurchaseKeyController extends Controller
{
    protected $purchaseKeyService;

    public function __construct(PurchaseKeyService $purchaseKeyService)
    {
       $this->purchaseKeyService = $purchaseKeyService;
    }

    public function showValidationForm()
    {
        return view('purchase-key-guard::pages.validation-form');
    }



    public function validatePurchase(PurchaseKeyStoreRequest $request)
    {
        try {
            $this->purchaseKeyService->validatePurchase($request);

            return redirect()->route('status', $request->purchase_code)->with('success', trans('purchase-key-guard::validation.purchase_key_guard.validation_successful'));
        } catch (PurchaseKeyStoreException $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        } catch (\Throwable $th) {
            info($th->getMessage());

            return redirect()->back()->withErrors(trans('purchase-key-guard::validation.purchase_key_guard.unexpected_error'))->withInput();
        }
    }

    public function showStatus($code)
    {
        $purchaseKey = $this->purchaseKeyService->showStatus($code);

        if (!$purchaseKey) {
            return redirect()->route('validate.form');
        }

        $status = [
            'purchase_code'   => $purchaseKey->purchase_code,
            'expiration_date' => $purchaseKey->expires_at,
            'domain'          => $purchaseKey->domain,
            'status'          => 'valid',
            'message'         => 'Purchase code is valid.',
        ];

        return view('purchase-key-guard::pages.status', compact('status'));
    }

    public function revalidatePurchaseForm()
    {
        return view('purchase-key-guard::pages.revalidation-form');
    }

    public function revalidatePurchase(PurchaseRevalidationRequest $request)
    {
        $purchaseKey = $this->purchaseKeyService->revalidatePurchase($request);

        if ($purchaseKey) {
            return redirect()->route('validate.success')->with('success', trans('purchase-key-guard::validation.purchase_key_guard.revalidation_successful'));
        } else {
            return redirect()->back()->withErrors(['purchase_code' => trans('purchase-key-guard::validation.purchase_key_guard.invalid_purchase_code')])->withInput();
        }
    }

    public function success()
    {
        return view('purchase-key-guard::pages.success');
    }





}
