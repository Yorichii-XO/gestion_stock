<?php

namespace Tests\Feature;
use App\Models\Client;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function test_can_create_client()
    {
        $response = $this->postJson('/api/clients', [
            'name' => 'Test Client',
            'email' => 'test@example.com',
            'phone' => '1234567890',
            'address' => 'Test Address',
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'name' => 'Test Client',
                     'email' => 'test@example.com',
                     'phone' => '1234567890',
                     'address' => 'Test Address',
                 ]);
    }

    public function test_can_get_all_clients()
    {
        Client::factory()->count(3)->create();

        $response = $this->getJson('/api/clients');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_can_get_single_client()
    {
        $client = Client::factory()->create();

        $response = $this->getJson("/api/clients/{$client->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'name' => $client->name,
                     'email' => $client->email,
                     'phone' => $client->phone,
                     'address' => $client->address,
                 ]);
    }

    public function test_can_update_client()
    {
        $client = Client::factory()->create();

        $response = $this->putJson("/api/clients/{$client->id}", [
            'name' => 'Updated Client',
            'email' => 'updated@example.com',
            'phone' => '0987654321',
            'address' => 'Updated Address',
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'name' => 'Updated Client',
                     'email' => 'updated@example.com',
                     'phone' => '0987654321',
                     'address' => 'Updated Address',
                 ]);
    }

    public function test_can_delete_client()
    {
        $client = Client::factory()->create();

        $response = $this->deleteJson("/api/clients/{$client->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('clients', [
            'id' => $client->id,
        ]);
    }
}
