<?php

namespace Jmrashed\PurchaseKeyGuard\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jmrashed\PurchaseKeyGuard\Models\PurchaseKey;

class VerifyPurchaseKey
{
    public function handle(Request $request, Closure $next)
    {
        $purchaseCode = trim((string) $request->header('X-Purchase-Code')); // Accept from header
        $domain = strtolower($request->getHost());

        if (empty($purchaseCode)) {
            return response()->json(['message' => trans('purchase-key-guard::validation.purchase_key_guard.missing_code')], 403);
        }

        $purchaseKey = PurchaseKey::where('purchase_code', $purchaseCode)->first();

        if (!$purchaseKey) {
            return response()->json(['message' => trans('purchase-key-guard::validation.purchase_key_guard.invalid_purchase_code')], 403);
        }

        if ($purchaseKey->status !== 'active' || $purchaseKey->is_revoked || ($purchaseKey->expires_at && $purchaseKey->expires_at->isPast())) {
            return response()->json(['message' => trans('purchase-key-guard::validation.purchase_key_guard.inactive_or_revoked')], 403);
        }

        $activatedDomains = $purchaseKey->activated_domains ?? [];

        if (!in_array($domain, $activatedDomains, true)) {
            $activationLimit = (int) config('purchase-key-guard.activation_limit', 1);

            if ($purchaseKey->activation_count >= $activationLimit) {
                return response()->json(['message' => trans('purchase-key-guard::validation.purchase_key_guard.limit_reached')], 403);
            }

            $activatedDomains[] = $domain;

            DB::transaction(function () use ($purchaseKey, $activatedDomains) {
                $purchaseKey->forceFill([
                    'activated_domains' => $activatedDomains,
                    'activation_count' => $purchaseKey->activation_count + 1,
                    'is_used' => true,
                ])->save();
            });
        }

        event('purchase.key.validated', $purchaseKey);

        return $next($request);
    }
}
