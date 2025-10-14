<?php

namespace Jmrashed\PurchaseKeyGuard\Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jmrashed\PurchaseKeyGuard\Models\PurchaseKey;
use Jmrashed\PurchaseKeyGuard\Tests\TestCase;

class PurchaseKeyControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_can_see_the_list_of_purchase_keys()
    {
        $this->withoutExceptionHandling();

        PurchaseKey::factory()->create();

        $response = $this->get(route('admin.purchase-keys.index'));

        $response->assertStatus(200);
        $response->assertViewIs('purchase-key-guard::admin.index');
        $response->assertViewHas('purchaseKeys');
    }

    /** @test */
    public function an_admin_can_see_the_create_purchase_key_form()
    {
        $response = $this->get(route('admin.purchase-keys.create'));

        $response->assertStatus(200);
        $response->assertViewIs('purchase-key-guard::admin.create');
    }

    /** @test */
    public function an_admin_can_create_a_new_purchase_key()
    {
        $this->withoutExceptionHandling();

        $purchaseKeyData = [
            'email' => 'test@example.com',
            'domain' => 'example.com',
            'purchase_code' => 'some-purchase-code',
            'status' => 'active',
        ];

        $response = $this->post(route('admin.purchase-keys.store'), $purchaseKeyData);

        $this->assertDatabaseHas('purchase_keys', $purchaseKeyData);
        $response->assertRedirect(route('admin.purchase-keys.index'));
        $response->assertSessionHas('success');
    }

    /** @test */
    public function an_admin_can_see_the_edit_purchase_key_form()
    {
        $purchaseKey = PurchaseKey::factory()->create();

        $response = $this->get(route('admin.purchase-keys.edit', $purchaseKey));

        $response->assertStatus(200);
        $response->assertViewIs('purchase-key-guard::admin.edit');
        $response->assertViewHas('purchaseKey', $purchaseKey);
    }

    /** @test */
    public function an_admin_can_update_a_purchase_key()
    {
        $purchaseKey = PurchaseKey::factory()->create();

        $updatedData = [
            'email' => 'updated@example.com',
            'domain' => 'updated.com',
            'purchase_code' => 'updated-code',
            'status' => 'inactive',
        ];

        $response = $this->put(route('admin.purchase-keys.update', $purchaseKey), $updatedData);

        $this->assertDatabaseHas('purchase_keys', $updatedData);
        $response->assertRedirect(route('admin.purchase-keys.index'));
        $response->assertSessionHas('success');
    }

    /** @test */
    public function an_admin_can_delete_a_purchase_key()
    {
        $purchaseKey = PurchaseKey::factory()->create();

        $response = $this->delete(route('admin.purchase-keys.destroy', $purchaseKey));

        $this->assertDatabaseMissing('purchase_keys', ['id' => $purchaseKey->id]);
        $response->assertRedirect(route('admin.purchase-keys.index'));
        $response->assertSessionHas('success');
    }

    /** @test */
    public function an_admin_can_revoke_a_purchase_key()
    {
        $purchaseKey = PurchaseKey::factory()->create();

        $response = $this->post(route('admin.purchase-keys.revoke', $purchaseKey));

        $this->assertDatabaseHas('purchase_keys', [
            'id' => $purchaseKey->id,
            'is_revoked' => true,
            'status' => 'inactive',
        ]);
        $response->assertRedirect(route('admin.purchase-keys.index'));
        $response->assertSessionHas('success');
    }
}
