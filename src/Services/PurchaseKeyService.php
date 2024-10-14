<?php

namespace Jmrashed\PurchaseKeyGuard\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PurchaseKeyService
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('purchase_key.api_url'); // Set your API URL from the config
    }

    /**
     * Validate the purchase code against the local database or the external API.
     *
     * @param string $purchaseCode
     * @param string $itemCode
     * @param string $domain
     * @return array
     */
    public function validatePurchaseCode($purchaseCode, $itemCode, $domain)
    {
        // Check local database for the purchase code
        $purchaseKey = DB::table('purchase_keys')->where('purchase_code', $purchaseCode)->first();

        if ($purchaseKey) {
            return ['status' => 'valid', 'message' => 'Purchase code is valid.'];
        }

        // If not found in the database, check with the external API
        $response = $this->validateWithApi($purchaseCode, $itemCode, $domain);

        if ($response['status'] === 'valid') {
            // Store the purchase key in the database for future checks
            $this->storePurchaseKey($purchaseCode, $itemCode, $domain);
            return $response;
        }

        return ['status' => 'invalid', 'message' => $response['message']];
    }

    /**
     * Revalidate the purchase code.
     *
     * @param string $purchaseCode
     * @return array
     */
    public function revalidatePurchaseCode($purchaseCode)
    {
        $purchaseKey = DB::table('purchase_keys')->where('purchase_code', $purchaseCode)->first();

        if ($purchaseKey) {
            // Call the external API for revalidation
            $response = $this->validateWithApi($purchaseCode, $purchaseKey->item_code, $purchaseKey->domain);

            if ($response['status'] === 'valid') {
                return $response;
            }

            return ['status' => 'invalid', 'message' => $response['message']];
        }

        return ['status' => 'invalid', 'message' => 'Purchase code not found in database.'];
    }

    /**
     * Install the purchase code and store it in the database.
     *
     * @param array $data
     * @return array
     */
    public function install(array $data)
    {
        // Validate if the purchase code is valid before installation
        $validationResponse = $this->validatePurchaseCode($data['purchase_code'], $data['item_code'], $data['domain']);

        if ($validationResponse['status'] === 'valid') {
            $this->storePurchaseKey($data['purchase_code'], $data['item_code'], $data['domain'], $data['installation_date']);
            return ['status' => 'success', 'message' => 'Installation completed successfully.'];
        }

        return ['status' => 'error', 'message' => $validationResponse['message']];
    }

    /**
     * Store the purchase key in the database.
     *
     * @param string $purchaseCode
     * @param string $itemCode
     * @param string $domain
     * @param string|null $installationDate
     * @return void
     */
    protected function storePurchaseKey($purchaseCode, $itemCode, $domain, $installationDate = null)
    {
        DB::table('purchase_keys')->insert([
            'purchase_code' => $purchaseCode,
            'item_code' => $itemCode,
            'domain' => $domain,
            'installation_date' => $installationDate ?? now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Validate the purchase code with the external API.
     *
     * @param string $purchaseCode
     * @param string $itemCode
     * @param string $domain
     * @return array
     */
    protected function validateWithApi($purchaseCode, $itemCode, $domain)
    {
        // Make a POST request to the external API for validation
        try {
            $response = Http::post($this->apiUrl, [
                'purchase_code' => $purchaseCode,
                'item_code' => $itemCode,
                'domain' => $domain,
                'installation_date' => now()->toDateTimeString(),
            ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('API validation failed: ' . $e->getMessage());
            return ['status' => 'invalid', 'message' => 'API validation failed. Please try again.'];
        }
    }

    /**
     * Get the current status of the purchase key.
     *
     * @return array|null
     */
    public function getCurrentStatus()
    {
        // Retrieve the latest purchase key status
        return DB::table('purchase_keys')->orderBy('created_at', 'desc')->first();
    }

    /**
     * Retrieve logs of purchase validation attempts.
     *
     * @return array
     */
    public function getLogs()
    {
        // This method should be implemented to retrieve logs if necessary
        // For now, we can return an empty array or logs from a specific table if you have one
        return [];
    }
}
