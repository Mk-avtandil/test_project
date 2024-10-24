<?php

namespace Tests\Feature\Comment;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    # for Route 'api/comments/'
    public function test_can_create_comments()
    {
        $user = User::factory()->create([
            'id' => 1,
            'name' => 'avtandil',
            'email' => 'avtandil@gmail.com',
            'password' => bcrypt('12345')
        ]);

        $product = Product::factory()->create([
            'id' => 78,
            'type' => 'test type product',
            'color' => 'blue',
            'size' => 20,
            'price' => 100,
            'quantity' => 10,
            'description' => 'This is a description'
        ]);

        $this->actingAs($user, 'sanctum');

        $comment = [
            'commentable_type' => 'App\Models\Product',
            'commentable_id' => $product->id,
            'body' => 'This is a test comment'
        ];

        $response = $this->postJson('/api/comments/', $comment);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'body' => 'This is a test comment',
                'user_id' => $user->id,
                'commentable_id' => $product->id,
                'commentable_type' => 'App\Models\Product',
            ]);

        $this->assertDatabaseHas('comments', [
            'commentable_id' => $product->id,
            'commentable_type' => 'App\Models\Product',
            'user_id' => $user->id,
            'body' => 'This is a test comment'
        ]);
    }

    public function test_unauthenticated_user_can_not_create_comments()
    {
        $product = Product::factory()->create([
            'type' => 'test type product',
            'color' => 'red',
            'size' => 200,
            'price' => 100,
            'quantity' => 9,
            'description' => 'This is a description'
        ]);

        $comment = [
            'commentable_type' => 'App\Models\Product',
            'commentable_id' => $product->id,
            'body' => 'This is a test comment'
        ];

        $response = $this->postJson('/api/comments/', $comment);

        $response->assertStatus(401);
    }

    public function test_create_comment_for_not_exist_product()
    {
        $user = User::factory()->create([
            'name' => 'avtandil',
            'email' => 'avtandil@gmail.com',
            'password' => bcrypt('12345')
        ]);

        $this->actingAs($user, 'sanctum');

        $comment = [
            'commentable_type' => 'App\Models\Product',
            'commentable_id' => 9999,
            'body' => 'This is a test comment'
        ];

        $response = $this->postJson('/api/comments/', $comment);

        $response->assertStatus(404);
    }
}
