<?php

namespace Jmrashed\PurchaseKeyGuard\Services;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Jmrashed\PurchaseKeyGuard\Models\PurchaseKey;
use Jmrashed\PurchaseKeyGuard\Services\EnvatoService;

class PurchaseKeyService
{
    protected $model;
    protected $apiUrl;
    protected $envatoService;

    public function __construct(PurchaseKey $model, EnvatoService $envatoService)
    {
        $this->model         = $model;
        $this->envatoService = $envatoService;
        $this->apiUrl        = config('purchase-key-guard.api_url');
    }

    public function validatePurchase($request)
    {
        $results         = [];
        $authentications = config('purchase-key-guard.authentication');

        // Loop through each authentication vendor to validate the purchase code
        foreach ($authentications as $vendor) {
            if ($vendor['token'] && $vendor['status']) {
                $result[] = $this->envatoService->verifyPurchaseCode($request->purchase_code, null, $vendor['token']);
            }
        }

        try {
            $this->model->create([
                'email'            => $request->input('email'),
                'domain'           => $request->input('domain'),
                'purchase_code'    => $request->input('purchase_code'),
                'expires_at'       => Carbon::now()->addYear()->format('Y-m-d H:i:s'),
                'activation_code'  => Str::random(16),
                'status'           => 'active',
                'is_used'          => false,
                'activation_count' => 0,
                'is_revoked'       => false,
                'revoked_at'       => null,
                'revoked_by'       => null,
                'created_by'       => auth()->id(),
                'notes'            => $request->input('notes'),
                'item_details'     => json_encode($results ?? []),
            ]);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function revalidatePurchase($request)
    {
        try {
            return $this->model->where("purchase_code", $request->purchase_code)->first();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function showStatus($code)
    {
        try {
            return $this->model->where("purchase_code", $code)->first();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function validatePurchaseCode(string $purchaseCode, string $itemCode, string $domain): array
    {
        try {
            $response = Http::post($this->apiUrl . '/validate', [
                'purchase_code' => $purchaseCode,
                'item_code' => $itemCode,
                'domain' => $domain,
            ]);

            if ($response->successful()) {
                return $response->json(); // Assuming the API returns a JSON response
            } else {
                return [
                    'status' => 'invalid',
                    'message' => 'Unable to validate purchase code. Please try again.',
                ];
            }
        } catch (\Exception $e) {
            Log::error('Purchase code validation error: ' . $e->getMessage());
            return [
                'status' => 'invalid',
                'message' => 'An error occurred during validation. Please try again later.',
            ];
        }
    }

    public function revalidatePurchaseCode(string $purchaseCode): array
    {
        try {
            $response = Http::post($this->apiUrl . '/revalidate', [
                'purchase_code' => $purchaseCode,
            ]);

            if ($response->successful()) {
                return $response->json(); // Assuming the API returns a JSON response
            } else {
                return [
                    'status' => 'invalid',
                    'message' => 'Unable to revalidate purchase code. Please try again.',
                ];
            }
        } catch (\Exception $e) {
            Log::error('Purchase code revalidation error: ' . $e->getMessage());
            return [
                'status' => 'invalid',
                'message' => 'An error occurred during revalidation. Please try again later.',
            ];
        }
    }

    public function getCurrentStatus(): array
    {
        return [
            'purchase_code' => 'example-code',
            'status' => 'valid',
            'expiration_date' => '2024-12-31',
            'message' => 'Purchase code is valid.',
        ];
    }
}
