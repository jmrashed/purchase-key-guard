<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Purchase Key Settings
    |--------------------------------------------------------------------------
    |
    | This file is for storing the purchase key settings for your package.
    | You can specify the default key type, expiration time, and other
    | settings that are necessary for purchase key validation and usage.
    |
    */

    'default_key' => env('PURCHASE_KEY', 'your-default-key'),

    'key_type' => env('PURCHASE_KEY_TYPE', 'single'), // Options: 'single', 'multi'

    'expiration_time' => env('PURCHASE_KEY_EXPIRATION', 30), // Expiration in days

    'logging' => [
        'enabled' => env('PURCHASE_KEY_LOGGING', true),
        'log_channel' => env('PURCHASE_KEY_LOG_CHANNEL', 'daily'), // Laravel log channel
    ],

    'database' => [
        'table' => env('PURCHASE_KEY_TABLE', 'purchase_keys'), // Database table name for storing keys
        'connection' => env('PURCHASE_KEY_DB_CONNECTION', 'mysql'), // Database connection
    ],

    'features' => [
        'allow_multiple_uses' => env('PURCHASE_KEY_ALLOW_MULTIPLE_USES', false), // Allow multiple uses of the same key
        'send_notification' => env('PURCHASE_KEY_SEND_NOTIFICATION', true), // Send notification on key validation
    ],
];
