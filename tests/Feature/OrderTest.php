<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->client = Client::factory()->create(); // Ensure there's a client
    }

    public function test_it_can_list_orders()
    {
        Order::factory()->count(3)->create();
        $response = $this->actingAs($this->user, 'sanctum')->getJson('/api/orders');
        $response->assertStatus(200)->assertJsonCount(3);
    }
    public function test_it_can_store_a_new_order()
    {
        $response = $this->actingAs($this->user, 'sanctum')->postJson('/api/orders', [
            'client_id' => $this->client->id,
            'user_id' => $this->user->id,
            'total_price' => 250.00,
            'status' => 'pending'
        ]);
    
        $response->assertStatus(201)
                 ->assertJson([
                     'client_id' => $this->client->id,
                     'user_id' => $this->user->id,
                     'total_price' => 250.00,
                     'status' => 'pending'
                 ]);
        
        $this->assertDatabaseHas('orders', [
            'client_id' => $this->client->id,
            'user_id' => $this->user->id,
            'total_price' => 250.00,
            'status' => 'pending'
        ]);
    }
    

    public function test_it_can_show_an_order()
    {
        $order = Order::factory()->create([
            'client_id' => $this->client->id,
            'user_id' => $this->user->id
        ]);

        $response = $this->actingAs($this->user, 'sanctum')->getJson('/api/orders/' . $order->id);
        $response->assertStatus(200)->assertJson([
            'client_id' => $order->client_id,
            'user_id' => $order->user_id,
            'total_price' => $order->total_price,
            'status' => $order->status
        ]);
    }

    public function test_it_can_update_an_order()
    {
        $order = Order::factory()->create([
            'client_id' => $this->client->id,
            'user_id' => $this->user->id,
            'total_price' => 100.00,
            'status' => 'pending'
        ]);

        $response = $this->actingAs($this->user, 'sanctum')->putJson('/api/orders/' . $order->id, [
            'total_price' => 150.00,
            'status' => 'completed'
        ]);

        $response->assertStatus(200)->assertJson([
            'total_price' => 150.00,
            'status' => 'completed'
        ]);
    }

    public function test_it_can_delete_an_order()
    {
        $order = Order::factory()->create([
            'client_id' => $this->client->id,
            'user_id' => $this->user->id
        ]);

        $response = $this->actingAs($this->user, 'sanctum')->deleteJson('/api/orders/' . $order->id);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
    }
}