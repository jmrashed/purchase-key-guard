<?php

namespace Jmrashed\PurchaseKeyGuard\Commands;

use Illuminate\Console\Command;
use Jmrashed\PurchaseKeyGuard\Models\PurchaseKey;

class CheckExpiredKeys extends Command
{
    protected $signature = 'purchase-key:check-expired';

    protected $description = 'Check for expired purchase keys and update their status.';

    public function handle()
    {
        $expiredKeys = PurchaseKey::where('expires_at', '<', now())
            ->where('status', '!=', 'expired')
            ->get();

        foreach ($expiredKeys as $key) {
            $key->update(['status' => 'expired']);
        }

        $this->info(count($expiredKeys) . ' expired keys have been updated.');
    }
}
