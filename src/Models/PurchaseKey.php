<?php

namespace Jmrashed\PurchaseKeyGuard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class PurchaseKey extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'purchase_keys';

    // Mass assignable attributes
    protected $fillable = [
        'email',
        'domain',
        'purchase_code',
        'expires_at',
        'activation_code',
        'status',
        'is_used',
        'activation_count',
        'is_revoked',
        'revoked_at',
        'revoked_by',
        'created_by',
        'notes',
        'item_details',
        'activated_domains',
    ];

    protected static function newFactory()
    {
        return \Jmrashed\PurchaseKeyGuard\Database\Factories\PurchaseKeyFactory::new();
    }

    // Casting attributes to their respective data types
    protected $casts = [
        'expires_at' => 'datetime',
        'revoked_at' => 'datetime',
        'is_used' => 'boolean',
        'is_revoked' => 'boolean',
        'activation_count' => 'integer',
        'activated_domains' => 'array',
        'item_details' => 'array',
    ];

    /**
     * Get the user associated with the purchase key.
     */
    public function user()
    {
        $userModel = config('auth.providers.users.model', \App\Models\User::class);

        return $this->belongsTo($userModel, 'created_by');
    }

    /**
     * Check if the purchase key is valid (not expired and not used).
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return !$this->is_used && ($this->expires_at === null || $this->expires_at->isFuture());
    }

    /**
     * Mark the purchase key as used.
     *
     * @return void
     */
    public function markAsUsed(): void
    {
        $this->is_used = true;
        $this->save();
    }
}
