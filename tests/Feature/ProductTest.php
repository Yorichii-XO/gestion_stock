<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_product()
    {
        $category = Category::factory()->create();
        $supplier = Supplier::factory()->create();

        $response = $this->postJson('/api/products', [
            'name' => 'Test Product',
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
            'quantity' => 10,
            'price' => 99.99,
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'name' => 'Test Product',
                'category_id' => $category->id,
                'supplier_id' => $supplier->id,
                'quantity' => 10,
                'price' => 99.99,
            ]);
    }

    public function test_can_get_all_products()
    {
        $products = Product::factory()->count(3)->create();

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_can_get_single_product()
    {
        $product = Product::factory()->create();

        $response = $this->getJson("/api/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJson([
                'name' => $product->name,
                'category_id' => $product->category_id,
                'supplier_id' => $product->supplier_id,
                'quantity' => $product->quantity,
                'price' => $product->price,
            ]);
    }

    public function test_can_update_product()
    {
        $product = Product::factory()->create();

        $response = $this->putJson("/api/products/{$product->id}", [
            'name' => 'Updated Product',
            'quantity' => 5,
            'price' => 49.99,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'name' => 'Updated Product',
                'quantity' => 5,
                'price' => 49.99,
            ]);
    }

    public function test_can_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }
}