<?php

namespace Jmrashed\PurchaseKeyGuard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Jmrashed\PurchaseKeyGuard\Services\PurchaseKeyService;
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

    // public function validatePurchase1(PurchaseKeyStoreValidation $request, EnvatoService $envatoService)
    // {
    //     $authentications = config('purchase-key-guard.authentication');
    //     $results = [];

    //     // Loop through each authentication vendor to validate the purchase code
    //     foreach ($authentications as $key => $vendor) {
    //         if ($vendor['token'] && $vendor['status']) {

    //             // Define the purchase code (for testing)
    //             $purchase_code = '8efaa60e-10a6-4317-84eb-e31408bb5969';

    //             try {
    //                 // Use cURL to request Envato API to validate the purchase code
    //                 $ch = curl_init("https://api.envato.com/v3/market/author/sale");

    //                 // Set the cURL options
    //                 curl_setopt_array($ch, [
    //                     CURLOPT_RETURNTRANSFER => true,
    //                     CURLOPT_USERAGENT => "Your Website / Contact: Your Email",
    //                     CURLOPT_HTTPHEADER => [
    //                         "Authorization: Bearer " . $vendor['token'],
    //                         "Content-Type: application/x-www-form-urlencoded",
    //                     ],
    //                     CURLOPT_POST => 1,
    //                     CURLOPT_POSTFIELDS => http_build_query([
    //                         "purchase_code" => $purchase_code,
    //                         "site_url" => $request->input('domain'),
    //                     ]),
    //                 ]);

    //                 // Execute the cURL request and get the response
    //                 $json = curl_exec($ch);
    //                 $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    //                 if (curl_errno($ch)) {
    //                     throw new \Exception('cURL error: ' . curl_error($ch));
    //                 }

    //                 // Check for invalid response codes
    //                 if ($code !== 200) {
    //                     throw new \Exception('API error: ' . $json);
    //                 }

    //                 // Decode the JSON response
    //                 $response = json_decode($json, true);

    //                 if (isset($response['error'])) {
    //                     throw new \Exception('Envato API Error: ' . $response['error']['message']);
    //                 }

    //                 // Store the API response for later use
    //                 $results[] = $response;
    //             } catch (\Exception $e) {
    //                 // Handle and log the cURL or Envato API exception
    //                 info('Error validating purchase code for vendor ' . $vendor['vendor'] . ': ' . $e->getMessage());
    //             }
    //         }
    //     }

    //     try {
    //         // Generate the activation code
    //         $activationCode = Str::random(16);

    //         // Store the purchase key in the database
    //         $this->model->create([
    //             'email' => $request->input('email'),
    //             'domain' => $request->input('domain'),
    //             'purchase_code' => $request->input('purchase_code'),
    //             'expires_at' => Carbon::now()->addYear()->format('Y-m-d H:i:s'),
    //             'activation_code' => $activationCode,
    //             'status' => 'active',
    //             'is_used' => false,
    //             'activation_count' => 0,
    //             'is_revoked' => false,
    //             'revoked_at' => null,
    //             'revoked_by' => null,
    //             'created_by' => auth()->id(),
    //             'notes' => $request->input('notes'),
    //             'item_details' => json_encode($results ?? []), // Store the results from the API
    //         ]);

    //         return redirect()->route('status', $request->purchase_code)
    //             ->with('success', 'Purchase code validated successfully.');
    //     } catch (\Throwable $th) {
    //         // Log and display database errors
    //         info('Error storing purchase key: ' . $th->getMessage());
    //         return redirect()->back()->withErrors('Failed to store purchase key')->withInput();
    //     }
    // }

    public function validatePurchase(PurchaseKeyStoreRequest $request)
    {
        try {
            $this->purchaseKeyService->validatePurchase($request);

            return redirect()->route('status', $request->purchase_code)->with('success', 'Purchase code validated successfully.');
        } catch (\Throwable $th) {
            info($th->getMessage());

            return redirect()->back()->withErrors('Failed to store purchase key')->withInput();
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
            return redirect()->route('validate.success')->with('success', 'Purchase code revalidated successfully.');
        } else {
            return redirect()->back()->withErrors(['purchase_code' => 'Invalid purchase code'])->withInput();
        }
    }

    public function success()
    {
        return view('purchase-key-guard::pages.success');
    }


    public function verify_user(Request $request)
    {
        $code = $request->code;
        $results = true;
        $envatoInfo = [];
        $personalToken = "fsHuTBwXZTlEqZYQacniBeNZFCrT01eZ";

        $code = trim($code);
        if (!preg_match("/^([a-f0-9]{8})-(([a-f0-9]{4})-){3}([a-f0-9]{12})$/i", $code)) {
            $results = false;
        }

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => "https://api.envato.com/v3/market/author/sale?code={$code}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer {$personalToken}",
                "User-Agent: Purchase code verification script"
            )
        ));

        $response = @curl_exec($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch) > 0) {
            $results = false;
        }

        switch ($responseCode) {
            case 404:
                $results = false;
            case 403:
                $results = false;
            case 401:
                $results = false;
        }

        if ($responseCode !== 200) {
            $results = false;
        }

        $body = @json_decode($response);

        if ($body === false && json_last_error() !== JSON_ERROR_NONE) {
            $results = false;
        }
        $response = $body;
        if ($results == true) {
            $checkInfo = EnvatoInfo::where('item_id', $response->item->id)->where('envato_username', $response->buyer)->first();
            if (!$checkInfo) {
                $envato = new EnvatoInfo();
                $envato->envato_username = $response->buyer;
                $envato->item_id = $response->item->id;
                $envato->item_name = $response->item->name;
                $envato->amount = $response->amount;
                $envato->item_url = $response->item->url;
                $envato->sold_at = $response->sold_at;
                $envato->user_purchase_count = $response->purchase_count;
                $envato->save();

                if ($envato->envato_username) {
                    $ch = curl_init();
                    curl_setopt_array($ch, array(
                        CURLOPT_URL => "https://api.envato.com/v1/market/user:{$envato->envato_username}.json",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_TIMEOUT => 20,
                        CURLOPT_HTTPHEADER => array(
                            "Authorization: Bearer {$personalToken}",
                            "User-Agent: User Information script"
                        )
                    ));
                    $userData = @curl_exec($ch);
                    $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    if ($responseCode == 200) {
                        $userBody = @json_decode($userData);
                        if ($userBody === false && json_last_error() !== JSON_ERROR_NONE) {
                            $results = false;
                        }
                        $envato->user_country = $userBody->user->country;
                        $envato->user_sales = $userBody->user->sales;
                        $envato->user_location = $userBody->user->location;
                        $envato->user_image = $userBody->user->image;
                        $envato->user_homepage_image = $userBody->user->homepage_image;
                        $envato->user_followers = $userBody->user->followers;
                        $envato->user_followers = $userBody->user->followers;
                        $envato->save();
                    }
                }
            }
        }

        $envatoInfo = EnvatoInfo::where('item_id', @$response->item->id)->where('envato_username', @$response->buyer)->first();
        return view('frontend.verify.index', compact('results', 'envatoInfo'));
    }

    public function verify_user_bd(Request $request)
    {
        $code = $request->code;
        $results = true;
        $envatoInfo = [];
        $personalToken = "aGPUug8SeQagLaSDZ3LXdKQ8x0hHNtlc";

        $code = trim($code);
        if (!preg_match("/^([a-f0-9]{8})-(([a-f0-9]{4})-){3}([a-f0-9]{12})$/i", $code)) {
            $results = false;
        }

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => "https://api.envato.com/v3/market/author/sale?code={$code}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer {$personalToken}",
                "User-Agent: Purchase code verification script"
            )
        ));

        $response = @curl_exec($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch) > 0) {
            $results = false;
        }

        switch ($responseCode) {
            case 404:
                $results = false;
            case 403:
                $results = false;
            case 401:
                $results = false;
        }

        if ($responseCode !== 200) {
            $results = false;
        }

        $body = @json_decode($response);

        if ($body === false && json_last_error() !== JSON_ERROR_NONE) {
            $results = false;
        }
        $response = $body;
        if ($results == true) {
            $checkInfo = EnvatoInfo::where('item_id', $response->item->id)->where('envato_username', $response->buyer)->first();
            if (!$checkInfo) {
                $envato = new EnvatoInfo();
                $envato->envato_username = $response->buyer;
                $envato->item_id = $response->item->id;
                $envato->item_name = $response->item->name;
                $envato->amount = $response->amount;
                $envato->item_url = $response->item->url;
                $envato->sold_at = $response->sold_at;
                $envato->user_purchase_count = $response->purchase_count;
                $envato->save();

                if ($envato->envato_username) {
                    $ch = curl_init();
                    curl_setopt_array($ch, array(
                        CURLOPT_URL => "https://api.envato.com/v1/market/user:{$envato->envato_username}.json",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_TIMEOUT => 20,
                        CURLOPT_HTTPHEADER => array(
                            "Authorization: Bearer {$personalToken}",
                            "User-Agent: User Information script"
                        )
                    ));
                    $userData = @curl_exec($ch);
                    $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    if ($responseCode == 200) {
                        $userBody = @json_decode($userData);
                        if ($userBody === false && json_last_error() !== JSON_ERROR_NONE) {
                            $results = false;
                        }
                        $envato->user_country = $userBody->user->country;
                        $envato->user_sales = $userBody->user->sales;
                        $envato->user_location = $userBody->user->location;
                        $envato->user_image = $userBody->user->image;
                        $envato->user_homepage_image = $userBody->user->homepage_image;
                        $envato->user_followers = $userBody->user->followers;
                        $envato->user_followers = $userBody->user->followers;
                        $envato->save();
                    }
                }
            }
        }

        $envatoInfo = EnvatoInfo::where('item_id', @$response->item->id)->where('envato_username', @$response->buyer)->first();
        return view('frontend.verify.indexBD', compact('results', 'envatoInfo'));
    }
}
