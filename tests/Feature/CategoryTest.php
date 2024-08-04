<?php

namespace Tests\Feature;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CategoryTest extends TestCase
{use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Manually create a user if not using factory
        $this->user = User::create([
            'name' => 'testuser',
            'password' => Hash::make('password'),
            'role' => 'user', // Ensure role_id exists in your roles table
        ]);

        // Authenticate the user with Sanctum
        Sanctum::actingAs($this->user);
    }

    /** @test */
    public function it_can_get_a_category()
    {
        // Arrange
        $category = Category::create([
            'name' => 'Electronics',
            'description' => 'Devices and gadgets',
        ]);

        // Act
        $response = $this->getJson('/api/categories/' . $category->id);

        // Assert
        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $category->id,
                     'name' => 'Electronics',
                     'description' => 'Devices and gadgets',
                 ]);
    }

    /** @test */
    public function it_can_create_a_category()
    {
        // Act
        $response = $this->postJson('/api/categories', [
            'name' => 'Furniture',
            'description' => 'Home and office furniture',
        ]);

        // Assert
        $response->assertStatus(201)
                 ->assertJson([
                     'name' => 'Furniture',
                     'description' => 'Home and office furniture',
                 ]);
    }

    /** @test */
    public function it_can_update_a_category()
    {
        // Arrange
        $category = Category::create([
            'name' => 'Old Name',
            'description' => 'Old description',
        ]);

        // Act
        $response = $this->putJson('/api/categories/' . $category->id, [
            'name' => 'Updated Name',
            'description' => 'Updated description',
        ]);

        // Assert
        $response->assertStatus(200)
                 ->assertJson([
                     'name' => 'Updated Name',
                     'description' => 'Updated description',
                 ]);
    }

    /** @test */
  

    /** @test */
    public function it_requires_authentication()
    {
        // Logout the user
        Sanctum::actingAs(null);

        // Act
        $response = $this->getJson('/api/categories');

        // Assert
        $response->assertStatus(401);
    }
}