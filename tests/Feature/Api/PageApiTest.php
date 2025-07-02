<?php

namespace Tests\Feature\Api;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PageApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
        Sanctum::actingAs($this->admin);
    }

    public function test_it_can_fetch_a_list_of_published_pages_as_an_admin(): void
    {
        Page::factory()->count(2)->create(['status' => 'published']);
        Page::factory()->create(['status' => 'draft']);

        $response = $this->getJson('/api/pages');

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.status', 'published');
    }

    public function test_it_can_fetch_a_single_published_page_by_slug_as_an_admin(): void
    {
        $page = Page::factory()->create(['status' => 'published']);
        $response = $this->getJson('/api/pages/' . $page->slug);
        $response->assertStatus(200)->assertJsonPath('data.title', $page->title);
    }

    public function test_it_returns_404_for_a_draft_page(): void
    {
        $page = Page::factory()->create(['status' => 'draft']);
        $response = $this->getJson('/api/pages/' . $page->slug);
        $response->assertStatus(404);
    }
}