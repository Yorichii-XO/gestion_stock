<?php

namespace Tests\Unit;

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    use RefreshDatabase;

    // /** @test */
    // public function it_can_create_a_client()
    // {
    //     $client = Client::create([
    //         'name' => 'John Doe',
    //         'email' => 'johndoe@example.com',
    //         'phone' => '1234567890',
    //         'address' => '123 Main St',
    //     ]);

    //     $this->assertDatabaseHas('clients', [
    //         'name' => 'John Doe',
    //         'email' => 'johndoe@example.com',
    //         'phone' => '1234567890',
    //         'address' => '123 Main St',
    //     ]);
    // }

    /** @test */
    // public function it_can_update_a_client()
    // {
    //     $client = Client::create([
    //         'name' => 'John Doe',
    //         'email' => 'johndoe@example.com',
    //         'phone' => '1234567890',
    //         'address' => '123 Main St',
    //     ]);

    //     $client->update([
    //         'name' => 'Jane Doe',
    //         'email' => 'janedoe@example.com',
    //         'phone' => '0987654321',
    //         'address' => '456 Another St',
    //     ]);

    //     $this->assertDatabaseHas('clients', [
    //         'name' => 'Jane Doe',
    //         'email' => 'janedoe@example.com',
    //         'phone' => '0987654321',
    //         'address' => '456 Another St',
    //     ]);
    // }

    /** @test */
    // public function it_can_delete_a_client()
    // {
    //     $client = Client::create([
    //         'name' => 'John Doe',
    //         'email' => 'johndoe@example.com',
    //         'phone' => '1234567890',
    //         'address' => '123 Main St',
    //     ]);

    //     $client->delete();

    //     $this->assertDatabaseMissing('clients', [
    //         'name' => 'John Doe',
    //         'email' => 'johndoe@example.com',
    //         'phone' => '1234567890',
    //         'address' => '123 Main St',
    //     ]);
    // }
}
