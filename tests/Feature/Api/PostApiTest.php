<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PostApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        // Create an admin user and authenticate for each test
        $this->admin = User::factory()->create(['role' => 'admin']);
        Sanctum::actingAs($this->admin);
    }

    public function test_it_can_fetch_a_list_of_published_posts_as_an_admin(): void
    {
        Post::factory()->count(2)->create(['status' => 'published', 'published_at' => now()]);
        $response = $this->getJson('/api/posts');
        $response->assertStatus(200)->assertJsonCount(2, 'data');
    }

    public function test_non_admin_user_cannot_access_posts_api(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        Sanctum::actingAs($user); // Authenticate as the non-admin user

        $response = $this->getJson('/api/posts');
        $response->assertStatus(403); // Forbidden
    }

    public function test_unauthenticated_user_cannot_access_posts_api(): void
    {
        auth('sanctum')->logout(); // Log out the current user
        $response = $this->getJson('/api/posts');
        $response->assertStatus(401); // Unauthorized
    }

    public function test_it_can_fetch_a_single_published_post_by_slug_as_an_admin(): void
    {
        $post = Post::factory()->create(['status' => 'published', 'published_at' => now()]);
        $response = $this->getJson('/api/posts/' . $post->slug);
        $response->assertStatus(200)->assertJsonPath('data.title', $post->title);
    }

    public function test_it_returns_404_for_a_draft_post(): void
    {
        $post = Post::factory()->create(['status' => 'draft']);
        $response = $this->getJson('/api/posts/' . $post->slug);
        $response->assertStatus(404);
    }

    public function test_it_can_filter_posts_by_category(): void
    {
        $categoryA = Category::factory()->create();
        $categoryB = Category::factory()->create();

        $postA = Post::factory()->create(['status' => 'published', 'published_at' => now()]);
        $postB = Post::factory()->create(['status' => 'published', 'published_at' => now()]);

        $postA->categories()->attach($categoryA);
        $postB->categories()->attach($categoryB);

        $response = $this->getJson('/api/posts?category=' . $categoryA->slug);

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', $postA->title);
    }
}