<?php

return [

    'required' => ':attribute is required.',
    'string'   => ':attribute must be a valid string.',
    'max'      => [
        'string' => ':attribute may not be greater than :max characters.',
    ],
    'url'      => ':attribute must be a valid URL.',
    'email'    => ':attribute must be a valid email address.',

    'purchase_key_guard' => [
        'validation_successful' => 'Purchase code validated successfully.',
        'revalidation_successful' => 'Purchase code revalidated successfully.',
        'invalid_purchase_code' => 'Invalid purchase code.',
        'duplicate_purchase_code' => 'Purchase code already exists.',
        'failed_to_store' => 'Failed to store purchase key.',
        'unexpected_error' => 'An unexpected error occurred.',
        'key_created' => 'Purchase key created successfully.',
        'key_updated' => 'Purchase key updated successfully.',
        'key_deleted' => 'Purchase key deleted successfully.',
        'key_revoked' => 'Purchase key revoked successfully.',
        'missing_code' => 'Purchase code is missing.',
        'inactive_or_revoked' => 'Purchase code is inactive, revoked, or expired.',
        'limit_reached' => 'Activation limit reached.',
    ],
];
