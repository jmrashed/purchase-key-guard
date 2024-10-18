<?php


namespace Jmrashed\PurchaseKeyGuard\Services;

use Illuminate\Support\Facades\Http;

class EnvatoService
{
    /**
     * Verify the purchase code using Envato API.
     *
     * @param string $purchaseCode
     * @param string $itemId
     * @param string $envatoToken
     * @return mixed
     */
    public function verifyPurchaseCode($purchaseCode, $itemId, $envatoToken)
    {
        // Envato verification endpoint
        $url = 'https://api.envato.com/v1/market/author/sale';

        // Make the request to the Envato API
        $response = Http::withToken($envatoToken)
            ->post($url, [
                'purchase_code' => $purchaseCode,
                'item_id'       => $itemId, // The item ID of the package or product
            ]);

        // Handle response
        if ($response->successful()) {
            return $response->json(); // Response as an associative array
        } else {
            // If API call fails, return the error message
            return $response->json();
        }
    }
}
