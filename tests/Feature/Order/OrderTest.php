<?php

namespace Tests\Feature\Order;

use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    # for Route 'api/orders/ POST'
    public function test_can_create_order()
    {
        $user = User::factory()->create([
            'id' => 1,
            'name' => 'avtandil',
            'email' => 'avtandil@gmail.com',
            'password' => bcrypt('12345')
        ]);

        $this->actingAs($user, 'sanctum');

        $product = Product::factory()->create([
            'id' => 78,
            'type' => 'test type product',
            'color' => 'blue',
            'size' => 20,
            'price' => 100,
            'quantity' => 10,
            'description' => 'This is a description'
        ]);

        $order = [
            'orderable_type' => 'App\Models\Product',
            'orderable_id' => $product->id,
            'quantity' => 2,
            'status' => 'pending',
        ];

        $response = $this->postJson('/api/orders/', $order);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'user_id' => $user->id,
                'orderable_id' => $product->id,
                'orderable_type' => 'App\Models\Product',
                'quantity' => 2,
                'status' => 'pending',
            ]);

        $this->assertDatabaseHas('orders', [
            'orderable_id' => $product->id,
            'orderable_type' => 'App\Models\Product',
            'quantity' => 2,
            'status' => 'pending',
        ]);
    }

    public function test_can_not_create_order_unauthenticated_user()
    {
        $product = Product::factory()->create([
            'id' => 78,
            'type' => 'test type product',
            'color' => 'blue',
            'size' => 20,
            'price' => 100,
            'quantity' => 10,
            'description' => 'This is a description'
        ]);

        $order = [
            'orderable_type' => 'App\Models\Product',
            'orderable_id' => $product->id,
            'quantity' => 2,
            'status' => 'pending',
        ];

        $response = $this->postJson('/api/orders/', $order);

        $response->assertStatus(401);
    }

    public function test_create_order_for_not_exist_product()
    {
        $user = User::factory()->create([
            'name' => 'avtandil',
            'email' => 'avtandil@gmail.com',
            'password' => bcrypt('12345')
        ]);

        $this->actingAs($user, 'sanctum');

        $order = [
            'orderable_type' => 'App\Models\Product',
            'orderable_id' => 9999,
            'quantity' => 0,
            'status' => 'pending',
        ];

        $response = $this->postJson('/api/orders/', $order);
        $response->assertStatus(404);
    }

    public function test_create_order_for_product_with_invalid_status()
    {
        $user = User::factory()->create([
            'id' => 1,
            'name' => 'avtandil',
            'email' => 'avtandil@gmail.com',
            'password' => bcrypt('12345')
        ]);

        $this->actingAs($user, 'sanctum');

        $product = Product::factory()->create([
            'id' => 78,
            'type' => 'test type product',
            'color' => 'yellow',
            'size' => 20,
            'price' => 1200,
            'quantity' => 100,
            'description' => 'This is a description'
        ]);

        $order = [
            'orderable_type' => 'App\Models\Product',
            'orderable_id' => $product->id,
            'quantity' => 1,
            'status' => 'awdawd',
        ];

        $response = $this->postJson('/api/orders/', $order);
        $response->assertStatus(422);
    }

    public function test_create_order_for_product_with_quantity_less_than_order_quantity()
    {
        $user = User::factory()->create([
            'id' => 1,
            'name' => 'avtandil',
            'email' => 'avtandil@gmail.com',
            'password' => bcrypt('12345')
        ]);

        $this->actingAs($user, 'sanctum');

        $product = Product::factory()->create([
            'id' => 78,
            'type' => 'test type product',
            'color' => 'yellow',
            'size' => 20,
            'price' => 1200,
            'quantity' => 10,
            'description' => 'This is a description'
        ]);

        $order = [
            'orderable_type' => 'App\Models\Product',
            'orderable_id' => $product->id,
            'quantity' => 11,
            'status' => 'completed',
        ];

        $response = $this->postJson('/api/orders/', $order);
        $response->assertStatus(422);
    }

    # for Route 'api/orders/ GET'
    public function test_can_get_orders()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $this->actingAs($user1, 'sanctum');

        $product = Product::factory()->create();

        Order::factory()->create([
            'user_id' => $user1->id,
            'orderable_id' => $product->id,
            'orderable_type' => 'App\Models\Product',
            'quantity' => 1,
            'status' => 'pending',
        ]);

        Order::factory()->create([
            'user_id' => $user2->id,
            'orderable_id' => $product->id,
            'orderable_type' => 'App\Models\Product',
            'quantity' => 2,
            'status' => 'completed',
        ]);

        $response = $this->getJson('/api/orders/');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    # for Route 'api/orders/{order} PUT'
    public function test_can_update_order_status()
    {
        $user = User::factory()->create([
            'id' => 1,
            'name' => 'avtandil',
            'email' => 'avtandil@gmail.com',
            'password' => bcrypt('12345')
        ]);

        $this->actingAs($user, 'sanctum');

        $product = Product::factory()->create();

        $order = Order::factory()->create([
            'user_id' => $user->id,
            'orderable_type' => 'App\Models\Product',
            'orderable_id' => $product->id,
            'status' => 'pending',
        ]);

        $response = $this->putJson("/api/orders/{$order->id}", ['status' => 'completed']);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $order->id,
                'status' => 'completed'
            ]);
    }
}
