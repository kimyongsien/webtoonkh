<?php

namespace Tests\Feature;

use App\Models\Story;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_bookmark_story()
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Action', 'slug' => 'action']);
        $story = Story::create(['title' => 'Story 1', 'category_id' => $category->id]);

        $response = $this->actingAs($user)
            ->post(route('stories.toggle-list', $story), ['type' => 'bookmark']);

        $response->assertRedirect();
        $this->assertDatabaseHas('user_lists', [
            'user_id' => $user->id,
            'story_id' => $story->id,
            'type' => 'bookmark'
        ]);

        // Toggle off
        $this->actingAs($user)
            ->post(route('stories.toggle-list', $story), ['type' => 'bookmark']);

        $this->assertDatabaseMissing('user_lists', [
            'user_id' => $user->id,
            'story_id' => $story->id,
            'type' => 'bookmark'
        ]);
    }

    public function test_user_can_save_story_to_read_later()
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Action', 'slug' => 'action']);
        $story = Story::create(['title' => 'Story 1', 'category_id' => $category->id]);

        $response = $this->actingAs($user)
            ->post(route('stories.toggle-list', $story), ['type' => 'read_later']);

        $response->assertRedirect();
        $this->assertDatabaseHas('user_lists', [
            'user_id' => $user->id,
            'story_id' => $story->id,
            'type' => 'read_later'
        ]);
    }

    public function test_user_can_rate_story()
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Action', 'slug' => 'action']);
        $story = Story::create(['title' => 'Story 1', 'category_id' => $category->id]);

        $response = $this->actingAs($user)
            ->post(route('stories.rate', $story), ['rating' => 5]);

        $response->assertRedirect();
        $this->assertDatabaseHas('ratings', [
            'user_id' => $user->id,
            'story_id' => $story->id,
            'rating' => 5
        ]);
    }

    public function test_view_history_is_recorded()
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Action', 'slug' => 'action']);
        $story = Story::create(['title' => 'Story 1', 'category_id' => $category->id]);

        $this->actingAs($user)->get(route('stories.show', $story));

        $this->assertDatabaseHas('view_histories', [
            'user_id' => $user->id,
            'story_id' => $story->id
        ]);
    }

    public function test_feedback_submission()
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Action', 'slug' => 'action']);
        $story = Story::create(['title' => 'Story 1', 'category_id' => $category->id]);

        $response = $this->actingAs($user)
            ->post(route('stories.feedback', $story), ['message' => 'Great story!']);

        $response->assertRedirect();
        $this->assertDatabaseHas('feedback', [
            'user_id' => $user->id,
            'story_id' => $story->id,
            'message' => 'Great story!'
        ]);
    }
}
