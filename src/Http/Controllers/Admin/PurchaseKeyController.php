<?php

namespace Jmrashed\PurchaseKeyGuard\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Jmrashed\PurchaseKeyGuard\Models\PurchaseKey;

class PurchaseKeyController extends Controller
{
    public function index()
    {
        $purchaseKeys = PurchaseKey::all();
        return view('purchase-key-guard::admin.index', compact('purchaseKeys'));
    }

    public function create()
    {
        return view('purchase-key-guard::admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'domain' => 'required|string',
            'purchase_code' => 'required|string|unique:purchase_keys,purchase_code',
            'expires_at' => 'nullable|date',
            'status' => 'required|in:active,inactive',
        ]);

        PurchaseKey::create([
            'email' => $request->email,
            'domain' => $request->domain,
            'purchase_code' => $request->purchase_code,
            'expires_at' => $request->expires_at,
            'status' => $request->status,
            'activation_code' => \Illuminate\Support\Str::random(16),
        ]);

        return redirect()->route('admin.purchase-keys.index')->with('success', trans('purchase-key-guard::validation.purchase_key_guard.key_created'));
    }

    public function edit(PurchaseKey $purchaseKey)
    {
        return view('purchase-key-guard::admin.edit', compact('purchaseKey'));
    }

    public function update(Request $request, PurchaseKey $purchaseKey)
    {
        $request->validate([
            'email' => 'required|email',
            'domain' => 'required|string',
            'purchase_code' => 'required|string|unique:purchase_keys,purchase_code,' . $purchaseKey->id,
            'expires_at' => 'nullable|date',
            'status' => 'required|in:active,inactive',
        ]);

        $purchaseKey->update($request->all());

        return redirect()->route('admin.purchase-keys.index')->with('success', trans('purchase-key-guard::validation.purchase_key_guard.key_updated'));
    }

    public function destroy(PurchaseKey $purchaseKey)
    {
        $purchaseKey->delete();

        return redirect()->route('admin.purchase-keys.index')->with('success', trans('purchase-key-guard::validation.purchase_key_guard.key_deleted'));
    }

    public function revoke(PurchaseKey $purchaseKey)
    {
        $purchaseKey->update([
            'is_revoked' => true,
            'revoked_at' => now(),
            'status' => 'inactive',
        ]);

        return redirect()->route('admin.purchase-keys.index')->with('success', trans('purchase-key-guard::validation.purchase_key_guard.key_revoked'));
    }
}
