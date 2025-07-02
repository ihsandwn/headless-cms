<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CategoryApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
        Sanctum::actingAs($this->admin);
    }

    public function test_it_can_fetch_a_list_of_categories_as_an_admin(): void
    {
        Category::factory()->count(3)->create();
        $response = $this->getJson('/api/categories');
        $response->assertStatus(200)->assertJsonCount(3, 'data');
    }

    public function test_it_can_fetch_a_single_category_by_slug_as_an_admin(): void
    {
        $category = Category::factory()->create();
        $response = $this->getJson('/api/categories/' . $category->slug);
        $response->assertStatus(200)->assertJsonPath('data.name', $category->name);
    }
}