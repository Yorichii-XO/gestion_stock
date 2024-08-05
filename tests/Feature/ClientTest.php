<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create(), 'sanctum');
    }

    public function test_it_can_list_clients()
    {
        $clients = Client::factory()->count(3)->create();
        $response = $this->getJson('/api/clients');

        $response->assertStatus(200);
        $response->assertJsonCount(3);

        $response->assertJsonStructure([
            '*' => ['id', 'name', 'email', 'phone', 'address', 'created_at', 'updated_at']
        ]);
        
        $responseData = $response->json();
        foreach ($clients as $client) {
            $this->assertTrue(in_array([
                'id' => $client->id,
                'name' => $client->name,
                'email' => $client->email,
                'phone' => $client->phone,
                'address' => $client->address,
                'created_at' => $client->created_at->toISOString(),
                'updated_at' => $client->updated_at->toISOString(),
            ], $responseData));
        }
    }


    public function test_it_can_store_a_new_client()
    {
        $clientData = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'phone' => '1234567890',
            'address' => '123 Main St',
        ];
        $response = $this->postJson('/api/clients', $clientData);
        $response->assertStatus(201)->assertJson($clientData);
    }

    public function test_it_can_show_a_client()
    {
        $client = Client::factory()->create();
        $response = $this->getJson('/api/clients/' . $client->id);
        $response->assertStatus(200)->assertJson([
            'id' => $client->id,
            'name' => $client->name,
            'email' => $client->email,
            'phone' => $client->phone,
            'address' => $client->address,
            'created_at' => $client->created_at->toISOString(),
            'updated_at' => $client->updated_at->toISOString(),
        ]);
    }

    public function test_it_can_update_a_client()
    {
        $client = Client::factory()->create();
        $updateData = [
            'name' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'phone' => '0987654321',
            'address' => '456 Another St',
        ];
        $response = $this->putJson('/api/clients/' . $client->id, $updateData);
        $response->assertStatus(200)->assertJson($updateData);
    }

    public function test_it_can_delete_a_client()
    {
        $client = Client::factory()->create();
        $response = $this->deleteJson('/api/clients/' . $client->id);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }
}