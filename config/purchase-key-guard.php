<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Purchase Key Authentication Settings
    |--------------------------------------------------------------------------
    |
    | This file stores the settings for purchase key authentication. You can
    | define multiple vendor accounts and their associated tokens and status.
    | These settings are necessary for validating and using purchase keys in
    | your application.
    |
    */

    'api_url' => env('PURCHASE_KEY_GUARD_API_URL', 'https://api.your-service.com'),

    'authentication' => [

        /*
         * Vendor Account 1 Configuration
         */
        [
            'vendor' => env('PURCHASE_KEY_VENDOR_ACCOUNT1', 'Account 1'),
            'token' => env('PURCHASE_KEY_TOKEN_ACCOUNT1', ''),
            'item_id' => env('PURCHASE_KEY_ITEM_ID_ACCOUNT1', ''),
            'status' => env('PURCHASE_KEY_STATUS_ACCOUNT1', false),
        ],

        /*
         * Vendor Account 2 Configuration
         */
        [
            'vendor' => env('PURCHASE_KEY_VENDOR_ACCOUNT2', 'Account 2'),
            'token' => env('PURCHASE_KEY_TOKEN_ACCOUNT2', ''),
            'item_id' => env('PURCHASE_KEY_ITEM_ID_ACCOUNT2', ''),
            'status' => env('PURCHASE_KEY_STATUS_ACCOUNT2', false),
        ],

        /*
         * Owner Account Configuration
         */
        [
            'vendor' => env('PURCHASE_KEY_VENDOR_OWNER', 'Owner'),
            'token' => env('PURCHASE_KEY_TOKEN_OWNER', ''),
            'item_id' => env('PURCHASE_KEY_ITEM_ID_OWNER', ''),
            'status' => env('PURCHASE_KEY_STATUS_OWNER', false),
        ]
    ],

    'activation_limit' => env('PURCHASE_KEY_ACTIVATION_LIMIT', 1),
];
