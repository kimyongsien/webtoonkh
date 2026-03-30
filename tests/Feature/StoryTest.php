<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Story;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_story_with_cover()
    {
        Storage::fake('public');

        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::create(['name' => 'Action', 'slug' => 'action']);

        $file = UploadedFile::fake()->image('cover.jpg');

        $response = $this->actingAs($admin)
            ->post(route('admin.stories.store'), [
                'title' => 'Test Story',
                'description' => 'A test description',
                'category_id' => $category->id,
                'cover' => $file,
                'drive_file_id' => '1234567890',
            ]);

        $response->assertRedirect(route('admin.stories.index'));
        
        $this->assertDatabaseHas('stories', [
            'title' => 'Test Story',
            'drive_file_id' => '1234567890',
        ]);

        $story = Story::first();
        Storage::disk('public')->assertExists($story->cover_path);
    }

    public function test_public_can_view_story()
    {
        $category = Category::create(['name' => 'Action', 'slug' => 'action']);
        $story = Story::create([
            'title' => 'Public Story',
            'description' => 'Desc',
            'category_id' => $category->id,
            'views' => 0,
        ]);

        $response = $this->get(route('stories.show', $story));

        $response->assertStatus(200);
        $response->assertSee('Public Story');
        
        $this->assertDatabaseHas('stories', [
            'id' => $story->id,
            'views' => 1,
        ]);
    }
}
