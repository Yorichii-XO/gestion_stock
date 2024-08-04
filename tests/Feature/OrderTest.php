<?php

namespace Tests\Feature;
use App\Models\Order;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function test_can_create_order()
    {
        $response = $this->postJson('/api/orders', [
            'client_id' => 1,
            'user_id' => 1,
            'total_price' => 100.00,
            'status' => 'pending',
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'client_id' => 1,
                     'user_id' => 1,
                     'total_price' => 100.00,
                     'status' => 'pending',
                 ]);
    }

    public function test_can_get_all_orders()
    {
        Order::factory()->count(3)->create();

        $response = $this->getJson('/api/orders');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_can_get_single_order()
    {
        $order = Order::factory()->create();

        $response = $this->getJson("/api/orders/{$order->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'client_id' => $order->client_id,
                     'user_id' => $order->user_id,
                     'total_price' => $order->total_price,
                     'status' => $order->status,
                 ]);
    }

    public function test_can_update_order()
    {
        $order = Order::factory()->create();

        $response = $this->putJson("/api/orders/{$order->id}", [
            'total_price' => 150.00,
            'status' => 'completed',
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'total_price' => 150.00,
                     'status' => 'completed',
                 ]);
    }

    public function test_can_delete_order()
    {
        $order = Order::factory()->create();

        $response = $this->deleteJson("/api/orders/{$order->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('orders', [
            'id' => $order->id,
        ]);
    }
}
