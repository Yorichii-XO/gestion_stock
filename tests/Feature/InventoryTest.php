<?php

namespace Tests\Feature;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class InventoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed');
        $this->actingAs(User::factory()->create(), 'sanctum');
    }

    public function test_it_can_list_inventories()
    {
        Inventory::factory()->count(3)->create();
        $response = $this->getJson('/api/inventories');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['id', 'location', 'capacity', 'current_stock', 'product_id', 'created_at', 'updated_at']
        ]);
    }

    public function test_it_can_store_a_new_inventory()
    {
        $product = Product::factory()->create();
        $inventoryData = [
            'location' => 'Warehouse A',
            'capacity' => 100,
            'current_stock' => 50,
            'product_id' => $product->id,
        ];

        $response = $this->postJson('/api/inventories', $inventoryData);

        $response->assertStatus(201)->assertJsonFragment([
            'location' => 'Warehouse A',
            'capacity' => 100,
            'current_stock' => 50,
            'product_id' => $product->id,
        ]);
    }

    public function test_it_can_show_an_inventory()
    {
        $product = Product::factory()->create();
        $inventory = Inventory::factory()->create(['product_id' => $product->id]);

        $response = $this->getJson('/api/inventories/' . $inventory->id);

        $response->assertStatus(200)->assertJson([
            'id' => $inventory->id,
            'location' => $inventory->location,
            'capacity' => $inventory->capacity,
            'current_stock' => $inventory->current_stock,
            'product_id' => $inventory->product_id,
            'created_at' => $inventory->created_at->toISOString(),
            'updated_at' => $inventory->updated_at->toISOString(),
        ]);
    }

    public function test_it_can_update_an_inventory()
    {
        $inventory = Inventory::factory()->create();
        $updateData = [
            'location' => 'Updated Location',
            'capacity' => 200,
            'current_stock' => 150,
        ];

        $response = $this->putJson('/api/inventories/' . $inventory->id, $updateData);

        $response->assertStatus(200)->assertJsonFragment($updateData);
    }

    public function test_it_can_delete_an_inventory()
    {
        $inventory = Inventory::factory()->create();

        $response = $this->deleteJson('/api/inventories/' . $inventory->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('inventories', ['id' => $inventory->id]);
    }
}