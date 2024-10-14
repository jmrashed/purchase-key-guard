<?php

namespace Jmrashed\PurchaseKeyGuard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Jmrashed\PurchaseKeyGuard\Services\PurchaseKeyService;
use Brian2694\Toastr\Facades\Toastr;

class PurchaseKeyController extends Controller
{
    protected $purchaseKeyService;

    public function __construct(PurchaseKeyService $purchaseKeyService)
    {
        $this->purchaseKeyService = $purchaseKeyService;
    }

    /**
     * Show the purchase validation form.
     *
     * @return \Illuminate\View\View
     */
    public function showValidationForm()
    {
        return view('purchase-key-guard::purchase_key.validation-form');
    }

    /**
     * Handle the purchase validation submission.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function validatePurchase(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'purchase_code' => 'required|string|max:255',
            'item_code' => 'required|string|max:255',
            'domain' => 'required|url',
        ]);

        if ($validator->fails()) {
            // Redirect back with validation errors
            foreach ($validator->errors()->all() as $error) {
                Toastr::error($error);
            }
            return redirect()->back()->withInput();
        }

        // Validate the purchase code using the service
        $result = $this->purchaseKeyService->validatePurchaseCode(
            $request->input('purchase_code'),
            $request->input('item_code'),
            $request->input('domain')
        );

        if ($result['status'] === 'valid') {
            Toastr::success('Purchase code validated successfully.');
            return redirect()->route('purchase-key.status');
        } else {
            Toastr::error($result['message']);
            return redirect()->back()->withInput();
        }
    }

    /**
     * Show the current purchase status.
     *
     * @return \Illuminate\View\View
     */
    public function showStatus()
    {
        $status = $this->purchaseKeyService->getCurrentStatus();
        return view('purchase-key-guard::purchase_key.status', compact('status'));
    }

    /**
     * Handle manual revalidation of the purchase code.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function revalidatePurchase(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'purchase_code' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Toastr::error($error);
            }
            return redirect()->back()->withInput();
        }

        // Revalidate the purchase code using the service
        $result = $this->purchaseKeyService->revalidatePurchaseCode($request->input('purchase_code'));

        if ($result['status'] === 'valid') {
            Toastr::success('Purchase code revalidated successfully.');
            return redirect()->route('purchase-key.status');
        } else {
            Toastr::error($result['message']);
            return redirect()->back()->withInput();
        }
    }

    /**
     * Show the purchase logs.
     *
     * @return \Illuminate\View\View
     */
    public function viewLogs()
    {
        // Retrieve logs using the service
        $logs = $this->purchaseKeyService->getLogs();
        return view('purchase-key-guard::purchase_key.logs', compact('logs'));
    }

    /**
     * Show the installation page.
     *
     * @return \Illuminate\View\View
     */
    public function showInstallForm()
    {
        return view('purchase-key-guard::purchase_key.installation-form');
    }

    /**
     * Handle the installation submission.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function install(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'purchase_code' => 'required|string|max:255',
            'item_code' => 'required|string|max:255',
            'domain' => 'required|url',
            'installation_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Toastr::error($error);
            }
            return redirect()->back()->withInput();
        }

        // Process the installation using the service
        $result = $this->purchaseKeyService->install($request->all());

        if ($result['status'] === 'success') {
            Toastr::success('Installation completed successfully.');
            return redirect()->route('purchase-key.status');
        } else {
            Toastr::error($result['message']);
            return redirect()->back()->withInput();
        }
    }
}
