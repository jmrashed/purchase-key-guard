<?php

namespace Jmrashed\PurchaseKeyGuard;

use Illuminate\Support\Facades\Facade;

/**
 * Class PurchaseKeyGuard
 * 
 * @method static \Jmrashed\PurchaseKeyGuard\Models\PurchaseKey createKey(string $key, string $userId = null)
 * @method static bool validateKey(string $key)
 * @method static bool revokeKey(string $key)
 * @method static \Illuminate\Database\Eloquent\Collection getKeysForUser(string $userId)
 */
class PurchaseKeyGuard extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'purchase-key-service';
    }
}
