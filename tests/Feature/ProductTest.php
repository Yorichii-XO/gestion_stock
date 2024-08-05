<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user);
    }

    public function test_it_can_list_products()
    {
        // Create 3 products
        Product::factory()->count(3)->create();
    
        // Act as a user with Sanctum
        $response = $this->actingAs($this->user, 'sanctum')->getJson('/api/products');
    
        // Check the response status
        $response->assertStatus(200);
    
        // Assert JSON structure and count of products
        $responseData = $response->json();
        $this->assertIsArray($responseData); // Ensure response is an array
        $this->assertCount(3, $responseData); // Assert there are 3 products
    }
    

    public function test_it_can_store_a_new_product()
    {
        $category = Category::factory()->create();
        $supplier = Supplier::factory()->create();

        $response = $this->postJson('/api/products', [
            'name' => 'Laptop',
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
            'quantity' => 10,
            'price' => 1000.00
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'name' => 'Laptop',
                     'category_id' => $category->id,
                     'supplier_id' => $supplier->id,
                     'quantity' => 10,
                     'price' => 1000.00
                 ]);
    }

    public function test_it_can_show_a_product()
    {
        $category = Category::factory()->create();
        $supplier = Supplier::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'supplier_id' => $supplier->id
        ]);

        $response = $this->getJson('/api/products/' . $product->id);

        $response->assertStatus(200)
                 ->assertJson([
                     'name' => $product->name,
                     'category_id' => $category->id,
                     'supplier_id' => $supplier->id,
                     'quantity' => $product->quantity,
                     'price' => $product->price
                 ]);
    }

    public function test_it_can_update_a_product()
    {
        $category = Category::factory()->create();
        $supplier = Supplier::factory()->create();
        $product = Product::factory()->create([
            'name' => 'Old Name',
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
            'quantity' => 10,
            'price' => 500.00
        ]);

        $response = $this->putJson('/api/products/' . $product->id, [
            'name' => 'New Name',
            'quantity' => 15,
            'price' => 600.00
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'name' => 'New Name',
                     'quantity' => 15,
                     'price' => 600.00
                 ]);
    }

    public function test_it_can_delete_a_product()
    {
        $category = Category::factory()->create();
        $supplier = Supplier::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'supplier_id' => $supplier->id
        ]);

        $response = $this->deleteJson('/api/products/' . $product->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}