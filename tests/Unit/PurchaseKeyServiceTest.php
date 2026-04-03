<?php

namespace Jmrashed\PurchaseKeyGuard\Tests\Unit;

use Illuminate\Support\Facades\Http;
use Jmrashed\PurchaseKeyGuard\Models\PurchaseKey;
use Jmrashed\PurchaseKeyGuard\Services\PurchaseKeyService;
use Jmrashed\PurchaseKeyGuard\Services\EnvatoService;
use Jmrashed\PurchaseKeyGuard\Exceptions\PurchaseKeyStoreException;
use Jmrashed\PurchaseKeyGuard\Tests\TestCase;

class PurchaseKeyServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->artisan('migrate', ['--database' => 'sqlite'])->run();
    }

    public function test_validate_purchase_stores_record_when_envato_confirms()
    {
        Http::fake([
            'https://api.envato.com/v1/market/author/sale' => Http::response(['item' => 'dummy'], 200),
        ]);

        $service = new PurchaseKeyService(new PurchaseKey(), new EnvatoService());

        $request = new \Illuminate\Http\Request([
            'email' => 'test@test.com',
            'domain' => 'example.com',
            'purchase_code' => 'ABC-123',
            'notes' => 'test',
        ]);

        $response = $service->validatePurchase($request);

        $this->assertDatabaseHas('purchase_keys', [
            'email' => 'test@test.com',
            'domain' => 'example.com',
            'purchase_code' => 'ABC-123',
            'status' => 'active',
        ]);
    }

    public function test_validate_purchase_throws_exception_for_duplicate_code()
    {
        PurchaseKey::factory()->create(['purchase_code' => 'DUPLICATE-1']);

        $this->expectException(PurchaseKeyStoreException::class);

        $service = new PurchaseKeyService(new PurchaseKey(), new EnvatoService());

        $request = new \Illuminate\Http\Request([    
            'email' => 'test@test.com',
            'domain' => 'example.com',
            'purchase_code' => 'DUPLICATE-1',
            'notes' => 'duplicate',
        ]);

        $service->validatePurchase($request);
    }
}
