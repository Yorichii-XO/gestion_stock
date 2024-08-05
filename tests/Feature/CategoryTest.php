<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{

    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_it_can_list_categories()
    {
        Category::factory()->count(3)->create();
        $response = $this->actingAs($this->user, 'sanctum')->getJson('/api/categories');
        $response->assertStatus(200)->assertJsonCount(3);
    }

    public function test_it_can_store_a_new_category()
    {
        $response = $this->actingAs($this->user, 'sanctum')->postJson('/api/categories', ['name' => 'Electronics']);
        $response->assertStatus(201)->assertJson(['name' => 'Electronics']);
    }

    public function test_it_can_show_a_category()
    {
        $category = Category::factory()->create();
        $response = $this->actingAs($this->user, 'sanctum')->getJson('/api/categories/' . $category->id);
        $response->assertStatus(200)->assertJson(['name' => $category->name]);
    }

    public function test_it_can_update_a_category()
    {
        $category = Category::factory()->create(['name' => 'Old Name']);
        $response = $this->actingAs($this->user, 'sanctum')->putJson('/api/categories/' . $category->id, ['name' => 'New Name']);
        $response->assertStatus(200)->assertJson(['name' => 'New Name']);
    }

    public function test_it_can_delete_a_category()
    {
        $category = Category::factory()->create();
        $response = $this->actingAs($this->user, 'sanctum')->deleteJson('/api/categories/' . $category->id);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}