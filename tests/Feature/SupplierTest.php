<?php

namespace Tests\Feature;

use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class SupplierTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed');
    }

    public function test_it_can_list_suppliers()
    {
        Supplier::factory()->count(3)->create();
        $response = $this->getJson('/api/suppliers');
        $response->assertStatus(200)->assertJsonCount(3);
    }

    public function test_it_can_store_a_new_supplier()
    {
        $response = $this->postJson('/api/suppliers', ['name' => 'ABC Supplies']);
        $response->assertStatus(201)->assertJson(['name' => 'ABC Supplies']);
    }

    public function test_it_can_show_a_supplier()
    {
        $supplier = Supplier::factory()->create();
        $response = $this->getJson('/api/suppliers/' . $supplier->id);
        $response->assertStatus(200)->assertJson(['name' => $supplier->name]);
    }

    public function test_it_can_update_a_supplier()
    {
        $supplier = Supplier::factory()->create(['name' => 'Old Name']);
        $response = $this->putJson('/api/suppliers/' . $supplier->id, ['name' => 'New Name']);
        $response->assertStatus(200)->assertJson(['name' => 'New Name']);
    }

    public function test_it_can_delete_a_supplier()
    {
        $supplier = Supplier::factory()->create();
        $response = $this->deleteJson('/api/suppliers/' . $supplier->id);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('suppliers', ['id' => $supplier->id]);
    }
}
