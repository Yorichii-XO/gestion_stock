<?php

namespace Tests\Feature;
use App\Models\Supplier;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SupplierTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function test_can_create_supplier()
    {
        $response = $this->postJson('/api/suppliers', [
            'name' => 'Test Supplier',
            'contact_info' => '1234567890',
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'name' => 'Test Supplier',
                     'contact_info' => '1234567890',
                 ]);
    }

    public function test_can_get_all_suppliers()
    {
        Supplier::factory()->count(3)->create();

        $response = $this->getJson('/api/suppliers');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_can_get_single_supplier()
    {
        $supplier = Supplier::factory()->create();

        $response = $this->getJson("/api/suppliers/{$supplier->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'name' => $supplier->name,
                     'contact_info' => $supplier->contact_info,
                 ]);
    }

    public function test_can_update_supplier()
    {
        $supplier = Supplier::factory()->create();

        $response = $this->putJson("/api/suppliers/{$supplier->id}", [
            'name' => 'Updated Supplier',
            'contact_info' => '0987654321',
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'name' => 'Updated Supplier',
                     'contact_info' => '0987654321',
                 ]);
    }

    public function test_can_delete_supplier()
    {
        $supplier = Supplier::factory()->create();

        $response = $this->deleteJson("/api/suppliers/{$supplier->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('suppliers', [
            'id' => $supplier->id,
        ]);
    }
}
