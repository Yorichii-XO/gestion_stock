<?php

namespace Tests\Feature;
use App\Models\Inventory;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InventoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function test_can_create_inventory()
    {
        $response = $this->postJson('/api/inventories', [
            'location' => 'Test Location',
            'capacity' => 500,
            'current_stock' => 100,
            'product_id' => 1,
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'location' => 'Test Location',
                     'capacity' => 500,
                     'current_stock' => 100,
                     'product_id' => 1,
                 ]);
    }

    public function test_can_get_all_inventories()
    {
        Inventory::factory()->count(3)->create();

        $response = $this->getJson('/api/inventories');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_can_get_single_inventory()
    {
        $inventory = Inventory::factory()->create();

        $response = $this->getJson("/api/inventories/{$inventory->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'location' => $inventory->location,
                     'capacity' => $inventory->capacity,
                     'current_stock' => $inventory->current_stock,
                     'product_id' => $inventory->product_id,
                 ]);
    }

    public function test_can_update_inventory()
    {
        $inventory = Inventory::factory()->create();

        $response = $this->putJson("/api/inventories/{$inventory->id}", [
            'location' => 'Updated Location',
            'capacity' => 600,
            'current_stock' => 200,
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'location' => 'Updated Location',
                     'capacity' => 600,
                     'current_stock' => 200,
                 ]);
    }

    public function test_can_delete_inventory()
    {
        $inventory = Inventory::factory()->create();

        $response = $this->deleteJson("/api/inventories/{$inventory->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('inventories', [
            'id' => $inventory->id,
        ]);
    }
}
