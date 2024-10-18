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

    'authentication' => [

        /*
         * Vendor Account 1 Configuration
         */
        [
            'vendor' => env('PURCHASE_KEY_VENDOR_ACCOUNT1', 'Account 1'),
            'token' => env('PURCHASE_KEY_TOKEN_ACCOUNT1', ''),
            'status' => env('PURCHASE_KEY_STATUS_ACCOUNT1', false),
        ],

        /*
         * Vendor Account 2 Configuration
         */
        [
            'vendor' => env('PURCHASE_KEY_VENDOR_ACCOUNT2', 'Account 2'),
            'token' => env('PURCHASE_KEY_TOKEN_ACCOUNT2', ''),
            'status' => env('PURCHASE_KEY_STATUS_ACCOUNT2', false),
        ],

        /*
         * Owner Account Configuration
         */
        [
            'vendor' => env('PURCHASE_KEY_VENDOR_OWNER', 'Owner'),
            'token' => env('PURCHASE_KEY_TOKEN_OWNER', ''),
            'status' => env('PURCHASE_KEY_STATUS_OWNER', false),
        ]
    ]
];
