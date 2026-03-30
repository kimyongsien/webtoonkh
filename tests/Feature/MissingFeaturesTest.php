<?php

namespace Tests\Feature;

use App\Models\Story;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function Pest\Laravel\{get, actingAs, travel};

uses(RefreshDatabase::class);

test('view count increments with cooldown', function () {
    $story = Story::factory()->create(['views' => 0]);

    // First visit
    get(route('stories.show', $story));
    expect($story->fresh()->views)->toBe(1);

    // Immediate second visit
    get(route('stories.show', $story));
    expect($story->fresh()->views)->toBe(1);

    // After 11 minutes
    travel(11)->minutes();
    get(route('stories.show', $story));
    expect($story->fresh()->views)->toBe(2);
});

test('ajax search returns correct results', function () {
    Story::factory()->create(['title' => 'Alpha Story']);
    Story::factory()->create(['title' => 'Beta Story']);

    $response = get(route('stories.search', ['q' => 'Alp']));
    
    $response->assertOk()
             ->assertJsonFragment(['title' => 'Alpha Story'])
             ->assertJsonMissing(['title' => 'Beta Story']);
});

test('admin feedback route is accessible only to admin', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create(['role' => 'user']);

    actingAs($admin)
        ->get(route('admin.feedback.index'))
        ->assertOk();

    actingAs($user)
        ->get(route('admin.feedback.index'))
        ->assertForbidden();
});
