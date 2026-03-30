<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Story;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_stories()
    {
        $category = Category::create(['name' => 'Action', 'slug' => 'action']);
        Story::create(['title' => 'Naruto', 'category_id' => $category->id]);
        Story::create(['title' => 'One Piece', 'category_id' => $category->id]);

        $response = $this->get(route('home', ['search' => 'Naruto']));

        $response->assertStatus(200);
        $response->assertSee('Naruto');
        $response->assertDontSee('One Piece');
    }

    public function test_filter_stories_by_category()
    {
        $cat1 = Category::create(['name' => 'Action', 'slug' => 'action']);
        $cat2 = Category::create(['name' => 'Romance', 'slug' => 'romance']);

        Story::create(['title' => 'Action Story', 'category_id' => $cat1->id]);
        Story::create(['title' => 'Romance Story', 'category_id' => $cat2->id]);

        $response = $this->get(route('home', ['category' => 'action']));

        $response->assertStatus(200);
        $response->assertSee('Action Story');
        $response->assertDontSee('Romance Story');
    }
}
