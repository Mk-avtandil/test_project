<?php

namespace Tests\Feature\Service;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    # for Route 'api/services/'
    public function test_can_get_services_with_paginate()
    {
        Service::factory()->count(49)->create();

        $response = $this->getJson('/api/services/?page=2');

        $response->assertStatus(200)
            ->assertJsonCount(24, 'data');
    }

    # for Route 'api/services/all'
    public function test_can_get_all_services()
    {
        Service::factory()->count(5)->create();

        $response = $this->getJson('api/services/all');

        $response->assertStatus(200);
    }

    # for Route 'api/services/{id}'
    public function test_can_get_service_by_id()
    {
        Service::factory()->create(['id' => 678]);

        $response = $this->getJson('/api/services/678');

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => 678]);
    }

    public function test_service_not_found_returns_404()
    {
        $response = $this->getJson('/api/services/10000');

        $response->assertStatus(404)
            ->assertJsonFragment(['message' => 'Service not found']);
    }
}
