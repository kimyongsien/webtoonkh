<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Story;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_dashboard_stats()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::create(['name' => 'Action', 'slug' => 'action']);
        Story::create(['title' => 'Story 1', 'views' => 100, 'category_id' => $category->id]);
        Story::create(['title' => 'Story 2', 'views' => 200, 'category_id' => $category->id]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('stats');
        $response->assertSee('300'); // Total views
        $response->assertSee('2'); // Total stories
    }
}
