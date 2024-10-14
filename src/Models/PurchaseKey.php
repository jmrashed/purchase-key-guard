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
        'key',
        'user_id',
        'type',
        'expires_at',
        'is_used',
    ];

    // Casting attributes to their respective data types
    protected $casts = [
        'expires_at' => 'datetime', // Automatically cast to Carbon instance
        'is_used' => 'boolean',      // Cast is_used to boolean
    ];

    /**
     * Get the user associated with the purchase key.
     */
    public function user()
    {
        return $this->belongsTo(User::class); // Assuming you have a User model
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
