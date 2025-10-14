<?php

namespace Jmrashed\PurchaseKeyGuard\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Jmrashed\PurchaseKeyGuard\Models\PurchaseKey;

class PurchaseKeyFactory extends Factory
{
    protected $model = PurchaseKey::class;

    public function definition()
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'domain' => $this->faker->domainName,
            'purchase_code' => $this->faker->uuid,
            'expires_at' => $this->faker->dateTimeBetween('+1 month', '+1 year'),
            'status' => 'active',
            'activation_code' => $this->faker->uuid,
        ];
    }
}
