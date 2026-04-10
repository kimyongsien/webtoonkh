<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Story::with('category')->orderBy('updated_at', 'desc');

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->has('category') && $request->category != '') {
             $query->whereHas('category', function ($q) use ($request) {
                 $q->where('slug', $request->category);
             });
        }

        $stories = $query->paginate(12)->withQueryString();
        $categories = \App\Models\Category::orderBy('name')->get();

        // Featured: Top 5 heavily viewed stories for the slider
        $featuredStories = Story::orderBy('views', 'desc')->take(5)->get();
        
        // Hottest: Top 10 by views for the sidebar list
        $hottestStories = Story::orderBy('views', 'desc')
            ->take(10)
            ->get();

        return view('welcome', compact('stories', 'categories', 'featuredStories', 'hottestStories'));
    }

    public function categories(Request $request)
    {
        // Load categories and for each, try to load one story (the most viewed) to use its cover
        $categories = \App\Models\Category::with(['stories' => function($query) {
            $query->orderBy('views', 'desc')->limit(1);
        }])->orderBy('name')->get();

        return view('categories.index', compact('categories'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $stories = Story::where('title', 'like', "%{$query}%")
                        ->select('id', 'title', 'cover_path')
                        ->limit(10)
                        ->get()
                        ->append('cover_url');
        return response()->json($stories);
    }

    public function show(Story $story)
    {
        $sessionKey = 'viewed_story_' . $story->id;
        $lastViewed = session()->get($sessionKey);

        // Cooldown: 10 minutes
        if (!$lastViewed || \Carbon\Carbon::parse($lastViewed)->diffInMinutes(now()) >= 10) {
            \Illuminate\Support\Facades\DB::table('stories')
                ->where('id', $story->id)
                ->increment('views');
            session()->put($sessionKey, now());

            // Track History if logged in
            if (auth()->check()) {
                \App\Models\ViewHistory::updateOrCreate(
                    ['user_id' => auth()->id(), 'story_id' => $story->id],
                    ['updated_at' => now()]
                );
            }
        }

        $episodes = $story->episodes()->paginate(10);

        return view('stories.show', compact('story', 'episodes'));
    }

    public function episode(Story $story, \App\Models\Episode $episode)
    {
        // View tracking logic for episodes
        $sessionKey = 'viewed_episode_' . $episode->id;
        $lastViewed = session()->get($sessionKey);

        if (!$lastViewed || \Carbon\Carbon::parse($lastViewed)->diffInMinutes(now()) >= 10) {
            $episode->increment('views');
            session()->put($sessionKey, now());
        }

        return view('episodes.show', compact('story', 'episode'));
    }
}
