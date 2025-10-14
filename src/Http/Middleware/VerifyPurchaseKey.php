<?php

namespace Jmrashed\PurchaseKeyGuard\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Jmrashed\PurchaseKeyGuard\Models\PurchaseKey;

class VerifyPurchaseKey
{
    public function handle(Request $request, Closure $next)
    {
        $purchaseCode = $request->header('X-Purchase-Code');
        $domain = $request->getHost();

        if (!$purchaseCode) {
            return response()->json(['message' => trans('purchase-key-guard::validation.purchase_key_guard.missing_code')], 403);
        }

        $purchaseKey = PurchaseKey::where('purchase_code', $purchaseCode)->first();

        if (!$purchaseKey) {
            return response()->json(['message' => trans('purchase-key-guard::validation.purchase_key_guard.invalid_purchase_code')], 403);
        }

        if ($purchaseKey->status !== 'active' || $purchaseKey->is_revoked || $purchaseKey->expires_at < now()) {
            return response()->json(['message' => trans('purchase-key-guard::validation.purchase_key_guard.inactive_or_revoked')], 403);
        }

        $activatedDomains = $purchaseKey->activated_domains ? json_decode($purchaseKey->activated_domains, true) : [];

        if (!in_array($domain, $activatedDomains)) {
            $activationLimit = config('purchase-key-guard.activation_limit');

            if ($purchaseKey->activation_count >= $activationLimit) {
                return response()->json(['message' => trans('purchase-key-guard::validation.purchase_key_guard.limit_reached')], 403);
            }

            $activatedDomains[] = $domain;
            $purchaseKey->update([
                'activated_domains' => json_encode($activatedDomains),
                'activation_count' => $purchaseKey->activation_count + 1,
                'is_used' => true,
            ]);
        }

        return $next($request);
    }
}
