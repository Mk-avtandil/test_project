<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    # for Route 'api/products/all'
    public function test_can_get_all_products()
    {
        Product::factory()->count(5)->create();

        $response = $this->getJson('api/products/all');

        $response->assertStatus(200);
    }


    # for Route 'api/products/{id}'
    public function test_can_get_product_by_id()
    {
        Product::factory()->create(['id' => 999]);

        $response = $this->getJson('/api/products/999');

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => 999]);
    }

    public function test_product_not_found_returns_404()
    {
        $response = $this->getJson('/api/products/9999');

        $response->assertStatus(404)
            ->assertJsonFragment(['message' => 'Product not found']);
    }


    # for Route 'api/products/' with filters
    public function test_can_get_products_by_type()
    {
        Product::factory()->create(['type' => 'test type for test']);

        $response = $this->getJson('api/products/?type=test type for test');

        $response->assertStatus(200)
            ->assertJsonFragment(['type' => 'test type for test']);
    }

    public function test_can_get_products_by_color()
    {
        Product::factory()->create(['color' => 'black']);

        $response = $this->getJson('api/products/?color=black');

        $response->assertStatus(200)
            ->assertJsonFragment(['color' => 'black']);
    }

    public function test_can_get_products_by_size()
    {
        Product::factory()->create(['size' => 99]);

        $response = $this->getJson('api/products/?size=99');

        $response->assertStatus(200)
            ->assertJsonFragment(['size' => 99]);
    }

    public function test_can_get_products_by_quantity()
    {
        Product::factory()->create(['quantity' => 3]);

        $response = $this->getJson('api/products/?quantity=3');

        $response->assertStatus(200)
            ->assertJsonFragment(['quantity' => 3]);
    }

    public function test_can_get_products_by_price_range()
    {
        Product::factory()->create(['price' => 100]);
        Product::factory()->create(['price' => 200]);

        $response = $this->getJson('/api/products?price_from=150&price_to=250');

        $response->assertStatus(200)
            ->assertJsonFragment(['price' => 200]);
    }

    public function test_can_get_filtered_product()
    {
        Product::factory()->create([
            'type' => 'test data',
            'color' => 'red',
            'size' => 85,
            'price' => 100,
            'quantity' => 10
        ]);

        $response = $this->getJson('api/products', [
            'type' => 'test data',
            'color' => 'red',
            'size' => 80,
            'price_from' => 99,
            'price_to' => 101,
            'quantity' => 9,
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'type' => 'test data',
                'color' => 'red',
                'size' => 85,
                'price' => 100,
                'quantity' => 10,
            ]);
    }

    public function test_can_not_get_filtered_product_by_non_matching_size()
    {
        Product::factory()->create([
            'type' => 'test data',
            'color' => 'red',
            'size' => 85,
            'price' => 100,
            'quantity' => 10
        ]);

        $response = $this->getJson('api/products?size=80');

        $response->assertStatus(200)
            ->assertJsonFragment(['data' => []]);
    }

    public function test_can_get_paginated_products()
    {
        Product::factory()->count(11)->create();

        $response = $this->getJson('/api/products?per_page=5&page=3');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }
}
